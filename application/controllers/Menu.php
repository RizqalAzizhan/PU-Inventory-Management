<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller 
{   
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model', "menu");
    }


    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');  

        if($this->form_validation->run() == false) {

            $this->load->view('templates/user-header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/user-footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Menu Added
           </div>');
           redirect('menu');
       
        }
    }


    public function hapus($id)
    {

        $this->menu->hapusMenu($id);
        $this->session->set_flashdata('flash', 'deleted');
        redirect('menu');
    }


    public function hapussubmenu($id)
    {

        $this->menu->hapusSubMenu($id);
        $this->session->set_flashdata('flash', 'deleted');
        redirect('menu/submenu');
    }




    public function subMenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');  
        $this->form_validation->set_rules('menu_id ', 'Menu',);  
        $this->form_validation->set_rules('url', 'Url', 'required');  
        $this->form_validation->set_rules('icon', 'Icon', 'required');   

        if($this->form_validation->run() == false) {
            
                $this->load->view('templates/user-header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('menu/submenu', $data);
                $this->load->view('templates/user-footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Sub Menu Added
           </div>');
           redirect('menu/submenu');
        }
    }

}