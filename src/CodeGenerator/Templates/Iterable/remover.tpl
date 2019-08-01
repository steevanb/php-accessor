    public function {{methodName}}(int {{parameterName}}): self
    {
        {%nullable%}if (is_iterable($this->{{property}})) === false) {
            return $this;
        }

        {%/nullable%}if (array_key_exists({{parameterName}}, $this->{{property}}) === false) {
            throw new \Exception('Key "' . {{parameterName}} . '" does not exist in ' . __CLASS__ . '::${{property}}.');
        }
        unset($this->{{property}}[{{parameterName}}]);
        $this->{{property}} = array_values($this->{{property}});

        return $this;
    }