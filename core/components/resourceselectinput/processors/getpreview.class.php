<?php
/**
 * Gets preview Data from given Resource
 */
class ContentResourceGetPreviewProcessor extends modProcessor {
    public function process()
    {
        $c = $this->modx->newQuery('modResource');
        $c->sortby('menuindex ', 'ASC');

        $results = array();
        $collection = $this->modx->getCollection('modResource', array(
    'id' => $_GET['resource_id']
));
        foreach ($collection as $resource) {
            $results[] = $resource->get(array('id', 'pagetitle','longtitle','description','introtext','alias'));
        }

        if (empty($results)) {
            return $this->failure($this->modx->lexicon('contentblocks.error.no_resources'));
        }

        return $this->outputArray($results);
    }
}
return 'ContentResourceGetPreviewProcessor';
