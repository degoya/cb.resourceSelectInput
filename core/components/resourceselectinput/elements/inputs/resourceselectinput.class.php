<?php

class ResourceSelectInput extends cbBaseInput {
    public $defaultIcon = 'chunk_A';
    public $defaultTpl = '[[+value]]';


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

        if ($this->modx->resource) {
            $resource_context_key = $this->modx->resource->get('context_key');
            $resource_id = $this->modx->resource->get('id');
            $resource_template = $this->modx->resource->get('template');
            $template = str_replace('[[+contextKey]]', $resource_context_key, $template);
            $template = str_replace('[[+id]]', $resource_id, $template);
            $template = str_replace('[[+template]]', $resource_template, $template);
        } else {
            $context_key = 'mgr';
        }       

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
                'key' => 'resource_context',
                'fieldLabel' => 'Limit Context',
                'xtype' => 'contentblocks-combo-boolean',
                'default' => '1',
                'description' => 'Set to yes to Limit to current context of the block or no to select from all available contexts'
            ),
            array(
                'key' => 'resource_limit',
                'fieldLabel' => 'Limit Resources',
                'xtype' => 'numberfield',
                'default' => '',
                'description' => 'Limit maximum amount of resources to return'
            ),
            array(
                'key' => 'resource_template',
                'fieldLabel' => 'Filter Templates',
                'xtype' => 'textfield',
                'default' => '0',
                'description' => 'include only templates from specified resources (csv), i.E. 1,6,8'
            ),
            array(
                'key' => 'sortfield',
                'fieldLabel' => 'Sortfield',
                'xtype' => 'textfield',
                'default' => 'pagetitle',
                'description' => 'Enter field to sort by i.E. publishedon,template,pagetitle or id'
            ),
            array(
                'key' => 'sortorder',
                'fieldLabel' => 'Sortorder',
                'xtype' => 'textfield',
                'default' => 'ASC',
                'description' => 'Enter ASC or DESC'
            ),
            array(
                'key' => 'resource_where',
                'fieldLabel' => 'where',
                'xtype' => 'textarea',
                'default' => '',
                'description' => 'enter json where to add to the query i.E.<br/>
                <strong>include only published IDs</strong> [{"published":"1"}]<br/>
                <strong>include from Parent IDs</strong> [{"parent:IN":[34,56]}]<br/>
                <strong>include IDs</strong> [{"id:IN":[68,69]}]<br/>
                <strong>exclude Page by Title</strong> [{"pagetitle:!=":"Home"}]<br/>
                <strong>exclude IDs</strong> [{"id:NOT IN":[67,68,69]}]'
            ),
        );
    }
}