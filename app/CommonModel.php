<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CommonModel extends Model
{
        public static function getAll($table,$where='',$join = '',$select = '*',$orderBy = '',$groupBy = '',$rawselect = '',$offset='',$limit='')
    {
    	$occation = DB::table($table);
    	if($join)
    	{
    		foreach($join as $row) // $join=array(array('users','users.id','group_members.user_id'));
			{
				$occation = $occation->leftJoin($row[0], $row[1], '=', $row[2]);
			}
    	}
    	if($where)
    	{
    		foreach($where as $wh) // $where=array(array('group_id','=',$value->id),array('group_members.status',2));
			{
				$occation = $occation->where($wh[0],  $wh[1], $wh[2]);
			}
    	}
    	if($select)
    	{
    		$occation = $occation->select($select);
    	}
        if($rawselect)
        {
            $i = 0;
            $sel[$i] = $rawselect[0];
            foreach ($rawselect as $key => $value) {
                if($i!='0')
                    $sel[$i] = DB::raw(''.$key.'('.$value.') as '.$key.'');
            $i++;    
            }
            $occation = $occation->select($sel);
        }
    	if($groupBy)
    	{
    		$occation = $occation->groupBy($groupBy);
    	}
    	if($orderBy)
    	{
    		$occation = $occation->orderBy($orderBy,'DESC');
    	}
        if($offset)
        {
            $occation = $occation->offset($offset);
        }
        if($limit)
        {
            $occation = $occation->limit($limit);
        }
    	$occations = $occation->get();
    	
    	return $occations;
    }
    public static function getAllRow($table,$where='',$join = '',$select = '*',$orderBy = '',$groupBy = '')
    {
    	$occation = DB::table($table);
    	if($join)
    	{
    		foreach($join as $row) // $join=array(array('users','users.id','group_members.user_id'));
			{
				$occation = $occation->leftJoin($row[0], $row[1], '=', $row[2]);
			}
    	}
    	if($where)
    	{
    		foreach($where as $wh) // $where=array(array('group_id','=',$value->id),array('group_members.status',2));
			{
				$occation = $occation->where($wh[0], $wh[1], $wh[2]);
			}
    	}
    	if($select)
    	{
    		$occation = $occation->select($select);
    	}
    	if($groupBy)
    	{
    		$occation = $occation->groupBy($groupBy);
    	}
    	if($orderBy)
    	{
    		$occation = $occation->orderBy($orderBy);
    	}
    	$occations = $occation->get()->first();

    	return $occations;
    }
    public function insertData($table,$arr)
    {
        $occation = DB::table($table);
        $occations = $occation->insertGetId($arr); //array('email' => 'john@example.com', 'votes' => 0)
        return $occations;
    }
    public function updateData($table,$arr,$where='')
    {
        $occation = DB::table($table);
        if($where)
        {
            foreach($where as $wh) // $where=array(array('group_id','=',$value->id),array('group_members.status',2));
            {
                $occation = $occation->where($wh[0], $wh[1], $wh[2]);
            }
        }
        $occations = $occation->update($arr); //array('email' => 'john@example.com', 'votes' => 0)
        return $occations;
    }
    public function deleteData($table,$where='')
    {
        $occation = DB::table($table);
        if($where)
        {
            foreach($where as $wh) // $where=array(array('group_id','=',$value->id),array('group_members.status',2));
            {
                $occation = $occation->where($wh[0], $wh[1], $wh[2]);
            }
        }
        $occations = $occation->delete();
        return $occations;
    }
}
