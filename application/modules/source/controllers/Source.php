<?php

class Source extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('source_model', 'source');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
	public function index() {
        $data['header']['title'] = "Source List";
        $data['header']['menu_base'] = "source";
         $data['body']['sources'] = $this->cm->select_all_asc("source", "id");
        $data['body']['page'] = "view";
        makeTemplateAdmin($data);
    }

    public function add()
    {
        $data['header']['title'] = "Source Add";
        $data['header']['menu_base'] = "source";
        $data['body']['page'] = "add";
        makeTemplateAdmin($data);
    }

    public function addSave()
    {
        $this->form_validation->set_rules('source_name', 'Source Name', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        }
        else
        {
            $data = array(
                "source_name" => $this->input->post('source_name'),
                "createDate" => date('Y-m-d H:i:s')
            );
            $this->cm->insert("source", $data);
            redirectAlert("source",lang('save_success'));
        }
    }

    public function edit($id)
    {
        $data['header']['title'] = "Source Edit";
        $data['header']['menu_base'] = "source";
        $data['body']['source'] = $this->cm->select_single_row("source", "id", $id);
        $data['body']['page'] = "edit";
        makeTemplateAdmin($data);
    }
          
    public function editSave($id)
    {
        $this->form_validation->set_rules('source_name', 'Source Name', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->add($id);
        }
        else
        {
            $data = array(
                "source_name" => $this->input->post('source_name'),
                "updateDate" => date('Y-m-d H:i:s')
            );
            $this->cm->update("source", $data, "id", $id);
            redirectAlert("source",lang('save_success'));
        }
    }

    public function delete($id)
    {
        $this->cm->delete("source", "id", $id);
        redirectAlert("source",lang('delete_success'));
    }

}
