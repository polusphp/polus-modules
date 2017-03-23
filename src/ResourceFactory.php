<?php

namespace Polus\Modules;

use Actus\Path;

class ResourceFactory
{
    protected $moduleNamespace;
    protected $resolver;

    public function __construct($ns, $resourcePath, Path $pathResolver)
    {
        $this->moduleNamespace = $ns;
        $this->resolver = $pathResolver;
        foreach (['template'] as $folder) {
            $this->resolver->add($resourcePath . '/' . $folder, $folder, Path::MOD_APPEND);
        }
    }

    public function resolveTemplatePath($file)
    {
        return $this->resolver->get('template:' . $this->moduleNamespace . '/' . $file);
    }
}
