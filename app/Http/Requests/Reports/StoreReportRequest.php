<?php

namespace APOSite\Http\Requests\Reports;

use App;
use Illuminate\Console\AppNamespaceDetectorTrait;
use APOSite\Http\Controllers\LoginController;
use APOSite\Http\Requests\Request;

class StoreReportRequest extends Request
{

    use AppNamespaceDetectorTrait;

    protected $filterNamespace = "Models\\Contracts\\Reports\\Types\\";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $type = $this->route('type');
        $user = LoginController::currentUser();
        try {
            return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@canStore', ['user' => $user]);
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    private function snakeToCamelCase($val)
    {
        $val = rtrim($val, 's');
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type = $this->route('type');
        try {
            return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@createRules');
        } catch (\ReflectionException $e) {
            return [];
        }
    }

    public function messages()
    {
        $type = $this->route('type');
        try {
            return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@errorMessages');
        } catch (\ReflectionException $e) {
            return [];
        }
    }

}