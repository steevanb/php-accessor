{%phpDoc%}    /** @param {{phpDocParameterType}} {{parameterName}} */
{%/phpDoc%}    public function {{methodName}}({%phpTypeHint%}{{phpTypeHint}} {%/phpTypeHint%}{{parameterName}}): self
    {
        $this->{{property}} = {{parameterName}};

        return $this;
    }