<?php namespace APOSite\Models\Reports\Types;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Transformers\ChapterMeetingTransformer;
use APOSite\Models\Reports\BaseModel;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Request;
use APOSite\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use League\Fractal\Manager;
use APOSite\Jobs\ProcessEvent;

class ChapterMeeting extends BaseModel {

    protected $fillable = ['minutes'];

    public function transformer(Manager $manager)
    {
        return new ChapterMeetingTransformer($manager);
    }

    public function computeValue(array $brotherData)
    {
        return 1;
    }

    public function createRules()
    {
        $rules = [
            //Rules for the core report data
            'description' => ['sometimes','required', 'min:40'],
            'event_date' => ['required', 'date'],
            'brothers' => ['required', 'array']
        ];
        $extraRules = [];
        if(Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function updateRules()
    {
        $rules = [
            'event_date' => ['sometimes','required'],
            'brothers'=> ['sometimes','required','array']
        ];
        $extraRules = [];
        if(Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
            }
        }
        return array_merge($rules,$extraRules);
    }

    public function errorMessages()
    {
        $extraMessages = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraMessages['brothers.' . $index . '.id.exists'] = 'The cwru id :input is not valid.';
            }
        }
        return $extraMessages;
    }

    public function onCreate()
    {
        $event = new ProcessEvent($this->id, get_class($this));
        Queue::push($event);
    }

    public function onUpdate()
    {
        $event = new ProcessEvent($this->id, get_class($this));
        Queue::push($event);
    }

    public function canStore(User $user)
    {
        return AccessController::isSecretary($user);
    }

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        return $query;
        // TODO: Implement applyRowLevelSecurity() method.
    }

    public static function applyReportFilters(QueryBuilder $query)
    {
        return $query;
    }

    public function canUpdate(User $user)
    {
        return AccessController::isSecretary($user);
    }

    public function canRead(User $user)
    {
        return true;
    }

    public function updatable()
    {
        return ['event_date','brothers'];
    }
}
