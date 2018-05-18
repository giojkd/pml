<?php
class Currency extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		
		// load required models
		$this->load->model('currency_model', 'currency');
        $this->load->library('form_validation');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $get_all = $this->currency->get_all();
        $this->layout->set('page_title', "Currency");
        $this->layout->set('parent', 'setting');
        $this->layout->set('child', 'currency');
        $this->layout->set('get_all', $get_all);

        $this->layout->buffer('content', 'setting/view');
        $this->layout->render();
    }

    public function add() {
        $this->layout->set('page_title', "Add currency");
        $this->layout->set('parent', 'setting');
        $this->layout->set('child', 'currency');

        $this->layout->buffer('content', 'setting/add');
        $this->layout->render();
    }

    public function addsave() {

        $config = array(
            array(
                'field'   => 'currency_name',
                'label'   => 'Currency Name',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'currency_code',
                'label'   => 'Currency Code',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'currency_symbol',
                'label'   => 'Currency Symbol',
                'rules'   => 'required'
            )
        );

        $this->form_validation->set_rules($config);

        if($this->form_validation->run() == FALSE)
        {
            $this->add();
        } else {
            $is_active = $this->input->post('status') == 'on' ? 1 : 0;
            $data = array(
                'currency_name'  =>  $this->input->post('currency_name'),
                'currency_code'  =>  $this->input->post('currency_code'),

                'currency_symbol'  =>  $this->input->post('currency_symbol'),
                'currency_order'  =>  $this->input->post('currency_order'),

                'currency_createDate'  =>  date('Y-m-d'),
                'currency_status' => $is_active,
            );
            $insert = $this->currency->insert($data);
            if($insert) {
                $this->session->set_flashdata('save_success', msg(lang('save_success'), 'success'));
                redirect(site_url()."setting/currency");
            }
        }
    }

    public function edit($id) {
        $get_data = $this->currency->get($id);
        $this->layout->set('page_title', "Edit Currency");
        $this->layout->set('parent', 'setting');
        $this->layout->set('child', 'currency');
        $this->layout->set('edit', $get_data);

        $this->layout->buffer('content', 'setting/edit');
        $this->layout->render();
    }

    public function editsave() {

        $config = array(
            array(
                'field'   => 'currency_name',
                'label'   => 'Currency Name',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'currency_code',
                'label'   => 'Currency Code',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'currency_symbol',
                'label'   => 'Currency Symbol',
                'rules'   => 'required'
            )
        );

        $this->form_validation->set_rules($config);
        $id = $this->input->post('eid');

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        } else {
            $is_active = $this->input->post('status') == 'on' ? 1 : 0;
            //$this->input->post('old_pass') == $this->input->post('password') ? $this->input->post('old_pass') : $this->user->save_change_password($id, $this->input->post('password'));
            $data = array(
                'currency_name'  =>  $this->input->post('currency_name'),
                'currency_code'  =>  $this->input->post('currency_code'),

                'currency_symbol'  =>  $this->input->post('currency_symbol'),
                'currency_order'  =>  $this->input->post('currency_order'),

                'currency_updateDate'  =>  date('Y-m-d'),
                'currency_status' => $is_active,
            );
            $update = $this->currency->update($id, $data);
            if($update) {
                $this->session->set_flashdata('save_success', msg(lang('save_success'), 'success'));
                redirect(site_url()."setting/currency");
            }
        }
    }

    public function delete($id) {
        $delete = $this->currency->delete($id);
        if($delete) {
            $this->session->set_flashdata('save_success', msg(lang('delete_success'), 'success'));
            redirect(site_url()."setting/currency");
        }
    }
}