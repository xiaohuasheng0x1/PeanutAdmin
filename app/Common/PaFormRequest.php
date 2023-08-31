<?php
declare(strict_types=1);


namespace App\Common;

use Hyperf\Validation\Request\FormRequest;

class PaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 公共规则
     * @return array
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        $operation = $this->getOperation();
        $method = $operation . 'Rules';
        $rules = ( $operation && method_exists($this, $method) ) ? $this->$method() : [];
        return array_merge($rules, $this->commonRules());
    }

    /**
     * @return string|null
     */
    protected function getOperation(): ?string
    {
        $path = explode('/', $this->getFixPath());
        do {
            $operation = array_pop($path);
        } while (is_numeric($operation));

        return $operation;
    }

    /**
     * request->path在单元测试中拿不到，导致PaFormRequest验证失败
     * 取uri中的path, fix
     * @return string|null
     */
    protected function getFixPath(): string
    {
        return ltrim($this->getUri()->getPath(), '/');
    }

}