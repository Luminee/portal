<?php

namespace Luminee\User\Repositories;

use Luminee\Base\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->db_models_path = realpath(__DIR__ . '/../Models');
    }

    public function findLabelById($id, $with = [])
    {
        return $this->setModel('label')->withRelated($with)->find($id);
    }

    public function listLabelWithByParams($params, $with = [], $order_by = [], $group_by = [])
    {
        $query = $this->setModel('label')->withRelated($with);
        isset($params['columns']) ? $query->selectRaw($params['columns']) : null;
        isset($params['parent_id']) ? $query->where('parent_id', $params['parent_id']) : null;
        isset($params['parent_ids']) ? $query->whereIn('parent_id', $params['parent_ids']) : null;
        isset($params['is_available']) ? $query->where('label.is_available', $params['is_available']) : null;
        isset($params['level']) ? $query->where('level', $params['level']) : null;
        isset($params['level_in']) ? $query->whereIn('level', $params['level_in']) : null;
        isset($params['label_type_id']) ? $query->where('label_type_id', $params['label_type_id']) : null;
        isset($params['id']) ? $query->where('label.id', $params['id']) : null;
        isset($params['ids']) ? $query->whereIn('label.id', $params['ids']) : null;
        isset($params['with_deleted']) ? $query->withTrashed() : null;
        if (isset($params['scopeMap'])) {
            $join = 'label_scope_map';
            $query->join($join, 'label.id', '=', "$join.label_id");
            isset($params['scope_id']) ? $query->where("$join.scope_id", $params['scope_id']) : null;
            isset($params['is_visible']) ? $query->where("$join.is_visible", $params['is_visible']) : null;
            isset($params['is_available']) ? $query->where("$join.is_available", $params['is_available']) : null;
        }
        isset($order_by) ? $query->queryOrderBy($order_by) : null;
        !empty($group_by) ? $this->queryGroupBy($group_by) : null;
        return $query->getCollection();
    }

    public function listLabelForTree()
    {
        $query = $this->setModel('label')
            ->join('label_scope_map', 'label.id', '=', 'label_scope_map.label_id')
            ->selectRaw('label.*')
            ->where('label_scope_map.scope_id', 2)
            ->where('label_scope_map.is_visible', 1)
            ->where('label.is_available', 1)
            ->where('label.label_type_id', 2)
            ->whereNull('label.deleted_at');
        $query->queryOrderBy(['label.parent_id' => 'desc', 'label.power' => 'asc', 'label.id' => 'asc']);
        return $query->getCollection();
    }

    public function listLabelWithByScopeId($scope_id, $with = [])
    {
        $query = $this->setModel('label')->withRelated($with);
        $query->join('label_scope_map', 'label_scope_map.label_id', '=', 'label.id');
        $query->where('label.label_type_id', 1);
        $query->where('label_scope_map.scope_id', $scope_id);
        return $query->selectRaw('label.*')->getCollection();
    }

    public function listScopeMapWithByParams($params, $with = [], $order_by = [])
    {
        $query = $this->setModel('scopeMap')->withRelated($with);
        isset($params['ids']) ? $query->whereIn('id', $params['ids']) : null;
        isset($params['label_id']) ? $query->where('label_id', $params['label_id']) : null;
        isset($params['label_ids']) ? $query->whereIn('label_id', $params['label_ids']) : null;
        isset($params['scope_id']) ? $query->where('scope_id', $params['scope_id']) : null;
        isset($params['scope_ids']) ? $query->whereIn('scope_id', $params['scope_ids']) : null;
        isset($order_by) ? $query->queryOrderBy($order_by) : null;
        return $query->getCollection();
    }

    public function createLabelByData($data)
    {
        return $this->setModel('label')->create($data);
    }

    public function createScopeMapByData($data)
    {
        return $this->setModel('scopeMap')->create($data);
    }

    public function createLabelAttributeByData($data)
    {
        return $this->setModel('attribute')->create($data);
    }

    public function batchInsertScopeMapByData($data)
    {
        return $this->setModel('scopeMap')->insert($data);
    }

    public function batchInsertLabelAttributeByData($data)
    {
        return $this->setModel('attribute')->insert($data);
    }

    public function batchUpdateLabelAttributeByData($data)
    {
        return $this->setModel('attribute')->update($data);
    }

    public function batchUpdateLabelAttributeByFiledsAndData($data, $Fileds)
    {
        return $this->setModel('attribute')->batchUpdateByFields($data, $Fileds);
    }

    public function batchUpdateLabelAttributeDecrementValue($label_ids)
    {
        return $this->setModel('attribute')->whereIn('label_id', $label_ids)->where('key', 'word_ids')->decrement('value');
    }

    public function updateLabelByData($label_id, $data)
    {
        return $this->setModel('label')->whereId($id)->update($data);
    }

    public function batchUpdateLabelByData($data)
    {
        return $this->setModel('label')->update($data);
    }

    public function updateLabelTypeByLabelIdAndScopeIdAndData($label_id, $scope_id, $data)
    {
        return $this->setModel('scopeMap')->whereFields(['label_id' => $label_id, 'scope_id' => $scope_id])->update($data);
    }

    public function updateLabelAttributeByData($id, $data)
    {
        return $this->setModel('attribute')->where('id', $id)->update($data);
    }

    public function updateAttributeByLabelIdAndDataAndKey($lable_id, $data, $key)
    {
        return $this->setModel('attribute')->whereFields(['label_id' => $lable_id, 'key' => $key])->update($data);
    }

    public function findLabelTypeByCode($code)
    {
        return $this->setModel('type')->where('code', $code)->getFirst();
    }

    public function findLabelScopeByCode($code)
    {
        return $this->setModel('scope')->where('code', $code)->getFirst();
    }

    public function listLabelAttributeWithByParams($params, $with = [])
    {
        $query = $this->setModel('attribute')->withRelated($with);
        isset($params['label_id']) ? $query->where('label_id', $params['label_id']) : null;
        isset($params['label_ids']) ? $query->whereIn('label_id', $params['label_ids']) : null;
        isset($params['key']) ? $query->where('key', $params['key']) : null;
        isset($params['value']) ? $query->where('value', $params['value']) : null;
        return $query->getCollectionOrPaginate($query, $params);
    }

    public function deleteUserById($id)
    {
        return $this->setModel('user')->delete($id);
    }

    public function deleteAccountById($id)
    {
        return $this->setModel('account')->delete($id);
    }


}