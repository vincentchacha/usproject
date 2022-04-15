<?php

namespace App\Models;

class Checklist_template_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'checklist_template';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $checklist_template_table = $this->db->prefixTable('checklist_template');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $checklist_template_table.id=$id";
        }

        $sql = "SELECT $checklist_template_table.*
        FROM $checklist_template_table
        WHERE $checklist_template_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_template_suggestion($keyword = "") {
        $checklist_template_table = $this->db->prefixTable('checklist_template');

        if ($keyword) {
            $keyword = $this->db->escapeString($keyword);
        }

        $where = "";

        $sql = "SELECT $checklist_template_table.title
        FROM $checklist_template_table
        WHERE $checklist_template_table.deleted=0  AND $checklist_template_table.title LIKE '%$keyword%' $where";

        return $this->db->query($sql)->getResult();
    }

}
