<?php namespace APOSite\Http\Transformers;

use APOSite\Models\Contracts\Reports\Types\ServiceReport;
use APOSite\Models\Users\User;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class ServiceReportTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(ServiceReport $report)
    {
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key) {
            $val = $item->pivot;
            unset($val->report_id);
            $val->id = $val->user_id;
            unset($val->user_id);
            $val->name = $item->getFullDisplayName();
            $val->hours = intval($item->pivot->value / 60);
            $val->minutes = $item->pivot->value % 60;
            unset($val->value);
            return $val;
        });
        $otherData = [
            'id' => $report->id,
            'href' => route('report_show',['id'=>$report->id,'type'=>'service_reports']),
            'event_name' => $report->event_name,
            'description' => $report->description,
            'event_date' => $report->event_date->toDateString(),
            'human_date' => $report->event_date->toFormattedDateString(),
            'submitter' => ['id'=>$report->creator_id,'display_name'=>User::find($report->creator_id)->fullDisplayName()],
            'project_type' => $report->project_type,
            'service_type' => $report->service_type,
            'location' => $report->location,
            'off_campus' => (boolean)$report->off_campus,
            'travel_time' => $report->travel_time,
            'submission_date' => $report->created_at->toDateTimeString(),
            'brothers' => $brothers
        ];
        return $otherData;
    }

}