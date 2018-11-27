<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator\Behavior;

trait TemplateTrait
{
    protected function getTemplateContent(string $filePath): string
    {
        $return = file_get_contents($filePath);
        if ($return === false) {
            throw new \Exception('Template "' . $filePath . '" not found.');
        }

        return $return;
    }

    protected function replaceTemplateVar(string &$code, string $var, ?string $value): void
    {
        $code = str_replace('{{' . $var . '}}', $value, $code);
    }

    protected function replaceTemplateVars(string &$code, array $vars): void
    {
        foreach ($vars as $var => $value) {
            $this->replaceTemplateVar($code, $var, $value);
        }
    }

    protected function showTemplateBlock(string &$code, string $name, bool $show = true): void
    {
        if ($show) {
            $code = str_replace('{%' . $name . '%}', null, $code);
            $code = str_replace('{%/' . $name . '%}', null, $code);
        } else {
            $posReturn = strpos($code, '{%' . $name . '%}');
            $posEndReturn = strpos($code, '{%/' . $name . '%}');
            if ($posReturn !== false && $posEndReturn !== false) {
                $code = substr($code, 0, $posReturn) . substr($code, $posEndReturn + strlen('{%/' . $name . '%}'));
            }
        }
    }
}
