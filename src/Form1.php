<?php

namespace Job\Form;

class Form
{
    use Illuminate\Container\Container;
    use Illuminate\Filesystem\Filesystem;
    use Illuminate\Translation\FileLoader;
    use Illuminate\Translation\Translator;
    use Illuminate\Validation\Factory;

    private $validation;
    private $validation_rules = [];
    private $date;

    public function __constructor($data, int $priority = 0)
    {
        $this->data = $data;
        $this->add_validation_rules(
            [
                'title' => 'sometimes|required|string|nullable',
                'description' => 'sometimes|required|string|nullable',
                'url' => ['string', 'regex:/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/watch\?v\=\w+$/' ],
                'autoplay' => 'required|boolean',
            ]
        );

        $loader = new FileLoader(new Filesystem(), 'lang');
        $translator = new Translator($loader, 'en');
        $this->validation = new Factory($translator, new Container());
        var_dump($this->validation);
    }


    public function to_array()
    {
        $this->validate_data();

        return get_object_vars($this);
    }

    protected function validate_data()
    {
        if (! empty($this->data) && empty($this->validation_rules)) {
            throw new Exception($this->type() . ' has data but no validation rules.');
        }

        $validator = $this->validation->make($this->data, $this->validation_rules);

        if ($validator->fails()) {
            throw new Exception($this->type() . ' has an incorrect data format.');
        }
    }
}
