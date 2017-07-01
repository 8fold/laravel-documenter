<?php

namespace Eightfold\Documenter\Traits;

trait HasDeclarationsTrait
{
    /**
     * Build the declaration for the class, function, property, parameter, trait, or
     * interface.
     *
     * Optional keys:
     * - **objectType:** class|function|property|interface|trait What type of object
     *                                                           are you declaring?
     * - **withLink:**   true|false Default established by declaration methods.
     *                              Whether to wrap the return string with an `anchor`
     *                              tag.
     * - **highlight:**  true|false Default established by declaration methods.
     *                              Whether to wrap certain elements with `span` tags.
     *
     * - **isAbstract:** true|false Whether the object is considered abstract
     *                              or not.
     *
     * - **showFinalKeyword:**    true|false Whether to display the final keyword.
     * - **showAbstractKeyword:** true|false Whether to display the abstract keyword.
     *                                       `isAbstract` must be true. `objectType`
     *                                       must be class or function.
     *
     * - **showStaticKeyword:** true|false Whether to display the static keyword for an
     *                                     `objectType` of function or property.
     * - **showAccessKeyword:** true|false Whether to display the access level for an
     *                                     `objectType` of funciton or property.
     *
     * - **showInterfaceKeyword:** true|false Whether to display the "interface"
     *                                        keyword. `objectType` must be
     *                                        "interface".
     * - **showTraitKeyword:** true|false Whether to display the "trait"
     *                                        keyword. `objectType` must be
     *                                        "trait".
     *
     * - **showFunctionKeyword:** true|false Whether to display the function keyword
     *                                       for an `objectType` of function.
     * - **showParameters:**      true|false Whether to display the parameters for an
     *                                         `objectType` of function.
     * - **showDefault:**        true|false Whether to display the parameter's default
     *                                       value.
     * - **showReturnType:**      true|false Whether to display the return type for
     *                                         an `objectType` must be class.
     *
     * - **showInterfaces:** true|false Whether to display the list of interfaces
     *                                 implemented by the class. `objectType` must be
     *                                 class.
     * - **showTraits:**     true|false Whether to display the list of traits used by
     *                                  the class. `objectType` must be class.
     * - **showParent:**     true|false Whether to display the parent class name.
     *                                  `objectType` must be class.
     *
     * @param  array $config Dictionary with possible keys listed above.
     *
     * @return string        An HTML string based on the configuration.
     */
    protected function buildDeclaration($config)
    {
        $config = (object) $config;
        $string = [];

        // all - Open link, if necessary
        if (isset($config->withLink) && $config->withLink) {
            $string[] = '<a class="call-signature" href="'. url($this->url()) .'">';
        }

        // class - Add abstract keyword, if necessary
        if ($this->isClassOrFunction($config)){
            if (method_exists($this, 'isFinal') && $this->isFinal()) {
                $string[] = $this->getHighlightedStringForConfigKey($config, 'showFinalKeyword', 'final');

            }

            if (method_exists($this, 'isAbstract') && $this->isAbstract()) {
                $string[] = $this->getHighlightedStringForConfigKey($config, 'showAbstractKeyword', 'abstract');

            }
        }

        if (isset($config->objectType) && $config->objectType == 'class') {
            $this->processClass($config, $string);

        } elseif (isset($config->objectType) && ($config->objectType == 'function' || $config->objectType == 'property')) {
            $this->processPropertyAndFunction($config, $string);

        } elseif (isset($config->objectType) && ($config->objectType == 'trait' || $config->objectType == 'interface')) {
            if ($config->objectType == 'trait') {
                $string[] = trim($this->getHighlightedStringForConfigKey($config, 'showTraitKeyword', 'trait') .' '. $this->name());

            } else {
                $string[] = trim($this->getHighlightedStringForConfigKey($config, 'showInterfaceKeyword', 'interface') .' '. $this->name());

            }

        } else {
            $string[] = $this->name();

        }

        // all - Close link, if necessary
        $string[] = (isset($config->withLink) && $config->withLink)
            ? '</a>'
            : '';
        return implode(' ', $string);
    }

    private function isClassOrFunction($config)
    {
        if (!isset($config->objectType)) {
            return false;
        }
        return ($config->objectType == 'class' || $config->objectType == 'function');
    }

    /**
     * [processClass description]
     * @param  [type] $config  [description]
     * @param  [type] &$string [description]
     * @return [type]          [description]
     */
    private function processClass($config, &$string)
    {
        $build = [];
        // class - Show class keyword, if necessary
        if (isset($config->showClassKeyword) && $config->showClassKeyword) {
            $build[] = $this->getHighlightedStringForConfigKey($config, 'showClassKeyword', 'class');
        }

        $build[] = $this->name();

        if (isset($config->showParent) && $config->showParent && method_exists($this, 'parent') && !is_null($this->parent())) {
            $build[] = (isset($config->highlight) && $config->highlight)
                ? $this->getHighlightedString('extends')
                : 'extends';
            $build[] = (isset($config->highlight) && $config->highlight)
                ? $this->getHighlightedString($this->parent()->name(), 'related')
                : $this->parent()->name();
        }

        // class - Build interfaces list, if necessary
        if (isset($config->showInterfaces) && $config->showInterfaces && method_exists($this, 'interfaces') && count($this->interfaces()) > 0) {
            $store = [];
            foreach ($this->interfaces() as $interface) {
                $store[] = (isset($config->highlight) && $config->highlight)
                    ? $this->getHighlightedString($interface->name(), 'related')
                    : $interface->name();
            }

            $build[] = (isset($config->highlight) && $config->highlight)
                ? $this->getHighlightedString('implements', 'implements-label')
                : 'implements';
            $build[] = implode(', ', $store);
        }

        // class - Build traits list, if necessary
        if (isset($config->showTraits) && $config->showTraits && method_exists($this, 'traits') && count($this->traits()) > 0) {
            $keyword = (count($this->traits()) > 1)
                ? 'traits'
                : 'trait';
            $traitsArray = [];
            foreach ($this->traits() as $trait) {
                // TODO: $trait should not be null
                if (!is_null($trait)) {
                $traitsArray[] = (isset($config->highlight) && $config->highlight)
                    ? $this->getHighlightedString($trait->name(), 'related')
                    : $trait->name();
                }
            }

            $build[] = (isset($config->highlight) && $config->highlight)
                ? $this->getHighlightedString('has '. $keyword, 'traits-label')
                : 'has '. $keyword;
            $build[] = implode(', ', $traitsArray);
        }
        $string[] = implode(' ', $build);
    }

    private function processPropertyAndFunction($config, &$string)
    {
        // function and property - Add static keyword, if necessary
        if (method_exists($this, 'isStatic') && $this->isStatic()) {
            $string[] = $this->getHighlightedStringForConfigKey($config, 'showStaticKeyword', 'static');
        }

        // function and property - Add access level keyword, if necessary
        if (method_exists($this, 'access')) {
            $string[] = $this->getHighlightedStringForConfigKey($config, 'showAccessKeyword', $this->access(), 'access');
        }

        if (isset($config->objectType) && $config->objectType == 'function') {
            $this->processFunction($config, $string);

        } else {
            $build = $this->name();
            if (isset($config->showDefault) && $config->showDefault && $this->hasDefault()) {
                $build .= ' = '. $this->defaultValue();

                if (isset($config->showTypeHint) && $config->showTypeHint && count($this->typeHint()) > 0) {
                    $build .= ':';

                }
            }
            $propString[] = $build;
            if (isset($config->showTypeHint) && $config->showTypeHint && count($this->typeHint()) > 0) {
                $propString[] = $this->getTypeHintString($config, $propString);
                // if (count($this->typeHint()) > 1) {
                //     foreach ($this->typeHint() as $typeHint) {
                //         $propString[] = $this->getHighlightedStringForConfigKey($config, 'showTypeHint', $typeHint->name, 'typehint');

                //     }

                // } else {
                //     $typeHint = $this->typeHint()[0];
                //     $propString[] = $this->getHighlightedStringForConfigKey($config, 'showTypeHint', $typeHint->name, 'typehint');

                // }
            }

            $string[] = implode(' ', $propString);
        }
    }

    private function getTypeHintString($config, &$propString)
    {
        $build = [];
        if (count($this->typeHint()) > 1) {
            foreach ($this->typeHint() as $typeHint) {
                if ($typeHint->name !== '[type]') {
                    $build[] = $this->getHighlightedStringForConfigKey($config, 'showTypeHint', $typeHint->name, 'typehint');

                }
            }

        } else {
            $typeHint = $this->typeHint()[0];
            if ($typeHint->name !== '[type]') {
                $build[] = $this->getHighlightedStringForConfigKey($config, 'showTypeHint', $typeHint->name, 'typehint');
            }
        }

        if (count($build) > 0) {
            $propString[] = implode('|', $build);

        }
    }

    private function processFunction($config, &$string)
    {
        // function - Show function keyword, if necessary
        if (isset($config->showFunctionKeyword) && $config->showFunctionKeyword) {
            $string[] = $this->getHighlightedStringForConfigKey($config, 'showFunctionKeyword', 'function');
        }

        // function - Build parameter list for function, if necessary
        $params = [];
        $paramsString = '';
        if (isset($config->showParameters) && $config->showParameters) {
            foreach ($this->parameters() as $parameter) {
                $params[] = $this->getParameterString($config, $parameter);

            }
            $paramsString = trim(implode(', ', $params));
        }

        // function - Build return string, if necessary
        $returnTypeString = '';
        if (isset($config->showReturnType) && $config->showReturnType && method_exists($this, 'hasReturn') && $this->hasReturn()) {
            $returnTypeString = ': '. $this->getHighlightedStringForConfigKey($config, 'showReturnType', $this->returnTypes(), 'typehint');

        }

        $string[] = $this->name() .'('. $paramsString .')'. $returnTypeString;
    }

    private function getParameterString($config, $parameter)
    {
        $paramString = '';
        if (count($parameter->typeHint()) > 0) {
            $build = [];
            $this->getTypeHintString($config, $build);

            $build[] = $this->getHighlightedStringForConfigKey($config, 'showParameters', $parameter->name(), 'parameter');

            $build[] = (isset($config->showDefault) && $config->showDefault && $parameter->hasDefault())
                ? '= '. $parameter->defaultValue()
                : '';

            $paramString = implode(' ', $build);
        }

        return trim($paramString);
    }

    private function getHighlightedStringForConfigKey($config, $configKey, $label, $elemClass = null)
    {
        if (isset($config->{$configKey}) && $config->{$configKey}) {
            if (isset($config->highlight) && $config->highlight) {
                return $this->getHighlightedString($label, $elemClass);

            }
            return $label;
        }
        return '';
    }

    private function getHighlightedString($label, $elemClass = null)
    {
        return (is_null($elemClass))
            ? '<span class="'. $label .'">'. $label .'</span>'
            : '<span class="'. $elemClass .'">'. $label .'</span>';
    }
}
