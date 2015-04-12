<?php
/**
 * Searches modResources.
 */
class ContentBlocksResourceSearchProcessor extends modObjectGetListProcessor {
    public $classKey = 'modResource';
    public $languageTopics = array('resource');
    public $defaultSortField = 'pagetitle';


 public function getData() {
    $data = array();
    $limit = intval($_GET['resource_limit']);
    $c = $this->modx->newQuery($this->classKey);
    $c = $this->prepareQueryBeforeCount($c);
    $data['total'] = $this->modx->getCount($this->classKey,$c);
    $c = $this->prepareQueryAfterCount($c);
    if ($limit > 0) {
        $c->limit($limit);
    }
    $data['results'] = $this->modx->getCollection($this->classKey,$c);
    return $data;
    }


    /**
     * Adjust the query prior to the COUNT statement to only get top contenders.
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $params['where'] = $_GET['resource_where'];
        $params['context'] = $_GET['resource_context'];
        $params['limit'] = intval($_GET['resource_limit']);
        $params['template'] = $_GET['resource_template'];
        $params['contextkey'] = $_GET['contextkey'];
        $params['sortfield'] = $_GET['sortfield'];
        $params['sortorder'] = $_GET['sortorder'];

        $query = $this->getProperty('query');
        $c->where(array(
            'deleted' => false,
        ));
        if ($query!='') {
            $c->where(array(
                'pagetitle:LIKE' => "%$query%"
            ));
        }

        if (!empty($params['limit'])) {
            $c->limit($params['limit']);
        }
        if (!empty($params['context']) && ($params['context'] == 1 || $params['context'] == 'true')) {
            $c->where(array('modResource.context_key' =>  $params['contextkey']));
        }

        if (!empty($params['template']) && ($params['template'] != 0)) {
            $templates = explode(',',$params['template']);
            $criteria = array();
            $criteria['template:IN'] = $templates;
            $c->where($criteria);
        }
        if (!empty($params['where'])) {
            $params['where'] = $this->modx->fromJSON($params['where']);
            $c->where($params['where']);
        }
        if (!empty($params['sortfield'])) {
            $c->sortby($params['sortfield'],$params['sortorder']);
        }
        $c->select($this->modx->getSelectColumns('modResource', 'modResource', '', array(
            'id',
            'pagetitle',
            'template'
        )));
        /* DEBUG SQL
            $c->prepare();
            $result = $c->toSQL();
            $this->modx->log(modX::LOG_LEVEL_ERROR, "Result: $result");
        */
        return $c;
    }

    /**
     * Prepare the row into an array.
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $charset = $this->modx->getOption('modx_charset', null, 'UTF-8');
        $objectArray = $object->toArray('', false, true);
        $objectArray['pagetitle'] = htmlentities($objectArray['pagetitle'], ENT_COMPAT, $charset);
        $objectArray['id'] = (string)$objectArray['id'];
        $objectArray['templatelabel'] = ' ('.$objectArray['id'].')';
        $objectArray['label'] = $objectArray['pagetitle'].$objectArray['templatelabel'];
        return $objectArray;
    }

    /**
     * Return arrays of objects (with count) converted to JSON.
     *
     * The JSON result includes two main elements, total and results. This format is used for list
     * results.
     *
     * @access public
     * @param array $array An array of data objects.
     * @param mixed $count The total number of objects. Used for pagination.
     * @return string The JSON output.
     */
    public function outputArray(array $array,$count = false) {
        /* DEBUG JSON
            $result = $this->modx->toJSON($array);
            $this->modx->log(modX::LOG_LEVEL_ERROR, "Result: $result");
        */
        return $this->modx->toJSON($array);
    }
}
return 'ContentBlocksResourceSearchProcessor';