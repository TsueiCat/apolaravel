<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

class ActiveMemberChapterMeetingRequirement extends MeetingBasedRequirement
{
    public static $name = "Chapter Meetings";
    public static $description = "Will attend at least eight (8) general chapter meetings each chapter semester.";

    protected $threshold = 8;
    protected $comparison = 'GEQ';

    public function getReports()
    {
        $semester = $this->semester;

        $chapter_meetings = $this->user->reports()->ChapterMeetings()->get();
        $chapter_meetings = $chapter_meetings->filter(function($report) use ($semester){
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->pivot->tag == 'chapter';
            return $val;
        });

        $exec_meetings = $this->user->reports()->ExecMeetings()->get();
        $exec_meetings = $exec_meetings->filter(function($report) use ($semester){
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->pivot->tag == 'chapter';
            return $val;
        });

        $pledge_meetings = $this->user->reports()->PledgeMeetings()->get();
        $pledge_meetings = $pledge_meetings->filter(function($report) use ($semester){
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->pivot->tag == 'chapter';
            return $val;
        });

        return $chapter_meetings->merge($exec_meetings)->merge($pledge_meetings);
    }

    public function computeValue()
    {
        $reports = $this->getReports($this->semester);
        return $reports->count();
    }

}
