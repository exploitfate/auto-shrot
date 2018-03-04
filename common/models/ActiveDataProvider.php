<?php

namespace common\models;

use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider as BaseActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\db\QueryInterface;

/**
 * Class ActiveDataProvider
 *
 * Fix incompatible with sql_mode=only_full_group_by
 * @package common\models
 */
class ActiveDataProvider extends BaseActiveDataProvider
{

    /**
     * @inheritdoc
     */
    protected function prepareTotalCount()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException(
                'The "query" property must be an instance of a class that implements the QueryInterface'.'
                 e.g. yii\db\Query or its subclasses.'
            );
        }
        $query = clone $this->query;
        if ($query instanceof Query) {
            // Get number of rows from informational_schema
            if (empty($query->sql) && $this->isSimpleQuery()) {
                $tableName = $this->getTableName();
                if (!empty($tableName)) {
                    return $this->getNumberOfInformationSchemaTableRow($this->getDbConnection(), $tableName);
                }
                // Get number of rows by primary key or first select's column
            } else {
                if (empty($query->select)) {
                    $query->select(['id']);
                } elseif (in_array('id', $query->select) && in_array('*', $query->select)) {
                    $query->select(['id']);
                } else {
                    $key = reset($query->select);
                    $query->select([$key]);
                }
            }
        }
        return (int) $query->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db);
    }

    /**
     * @return bool
     */
    private function isSimpleQuery()
    {
        /** @var ActiveQuery $query */
        $query = $this->query;
        if (!empty($query->where)) {
            return false;
        }
        if (!empty($query->join)) {
            return false;
        }
        if (!empty($query->joinWith)) {
            return false;
        }
        if (!empty($query->groupBy)) {
            return false;
        }
        if (!empty($query->distinct)) {
            return false;
        }
        if (!empty($query->having)) {
            return false;
        }
        if (!empty($query->union)) {
            return false;
        }

        return true;
    }

    /**
     * @return Connection
     */
    private function getDbConnection()
    {
        /** @var ActiveQuery $query */
        $query = $this->query;

        if ($query instanceof ActiveQuery && !empty($query->modelClass)) {
            /** @var ActiveRecord $modelClass */
            $modelClass = $query->modelClass;
            return $modelClass::getDb();
        }

        return \Yii::$app->getDb();
    }


    /**
     * @param Connection $dbConnection
     * @param string $tableName
     * @return int
     */
    private function getNumberOfInformationSchemaTableRow($dbConnection, $tableName)
    {
        return (integer)(new Query())
            ->addSelect(['table_rows'])
            ->from('information_schema.tables')
            ->andWhere(new Expression("tables.table_schema = database()"))
            ->andWhere(['tables.table_name' => $tableName])
            ->scalar($dbConnection);
    }

    /**
     * @return null|string
     */
    private function getTableName()
    {
        /** @var ActiveQuery $query */
        $query = $this->query;

        $tableName = null;
        if ($query instanceof ActiveQuery && !empty($query->modelClass)) {
            /** @var ActiveRecord $modelClass */
            $modelClass = $query->modelClass;
            $tableName = $modelClass::tableName();
        }
        if (empty($tableName) && !empty($query->from) && is_string($query->from)) {
            $tableName = (string)$query->from;
        }

        return $tableName;
    }
}
