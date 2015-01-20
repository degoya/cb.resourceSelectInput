<?php
/**
 * Gets a list of resources
 */
class ContentResourceGetListProcessor extends modProcessor {
    public function process()
    {
        $c = $this->modx->newQuery('modResource');
        $c->sortby('menuindex ', 'ASC');

        $results = array();
        $collection = $this->modx->getCollection('modResource', array(
    'published' => $_GET['resource_published'],
    'searchable' => $_GET['resource_searchable'],
    'parent' => $_GET['resource_parent_id']
));
        foreach ($collection as $resource) {
            $results[] = $resource->get(array('id', 'pagetitle'));
        }

        if (empty($results)) {
            return $this->failure($this->modx->lexicon('contentblocks.error.no_resources'));
        }

        return $this->outputArray($results);
    }
}
return 'ContentResourceGetListProcessor';
