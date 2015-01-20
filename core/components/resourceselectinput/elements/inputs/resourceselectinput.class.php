<?php

class ResourceSelectInput extends cbBaseInput {
    public $defaultIcon = 'chunk_A';
    public $defaultTpl = '<resource>[[+value]]</resource>';


    /**
     * @return array
     */
    public function getJavaScripts() {
        $assetsUrl = $this->modx->getOption('resourceselectinput.assets_url', null, MODX_ASSETS_URL . 'components/resourceselectinput/');
        return array(
            $assetsUrl . 'js/inputs/resourceselect.input.js',
        );
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        $tpls = array();

        // Grab the template from a .tpl file
        $corePath = $this->modx->getOption('resourceselectinput.core_path', null, MODX_CORE_PATH . 'components/resourceselectinput/');

        $template = file_get_contents($corePath . 'templates/resourceselectinput.tpl');

        // Wrap the template, giving the input a reference of "resourceselectinput", and
        // add it to the returned array.
        $tpls[] = $this->contentBlocks->wrapInputTpl('resourceselectinput', $template);
        return $tpls;
    }

    public function getName()
    {
        return 'Resource Select Input';
        //return $this->modx->lexicon('resourceselectinput.name');
    }

    public function getDescription()
    {
        return 'Input box for resources';
        //return $this->modx->lexicon('resourceselectinput.description');
    }



    public function getFieldProperties()
    {
        return array(
            array(
                'key' => 'resource_parent_id',
                'fieldLabel' => 'Parent Resource ID to get Child list from',
                'xtype' => 'textfield',
                'default' => '0',
                'description' => 'Enter Partent Resource ID enter 0 for root of context'
            ),
            array(
                'key' => 'resource_published',
                'fieldLabel' => 'Show only published Resources',
                'xtype' => 'textfield',
                'default' => '1',
                'description' => 'Enter 1 to show only published and 0 to show unpublished'
            ),
            array(
                'key' => 'resource_searchable',
                'fieldLabel' => 'Show only searchable Resources',
                'xtype' => 'textfield',
                'default' => '1',
                'description' => 'Enter 1 to show only searchable and 0 to show nonsearchable'
            ),

        );
    }
}