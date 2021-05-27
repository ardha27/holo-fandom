<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Member extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model', 'member');

        $this->methods['index_get']['limit'] = 1000;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $member = $this->member->getmember();
        } else {
            $member = $this->member->getmember($id);
        }

        if ($member) {
            $this->response([
                'status' => true,
                'data' => $member
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    public function index_delete() {
        $id = $this->delete('id');

        if ($id == NULL) {
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->member->deletemember($id) >0 ) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post() {
        $data = [
            'name' => $this->post('name'),
            'gen' => $this->post('gen'),
            'debut_date' => $this->post('debut_date'),
            'debut_video' => $this->post('debut_video'),
            'yt_channel' => $this->post('yt_channel'),
            'twitter' => $this->post('twitter'),
            'mama' => $this->post('mama'),
            'papa' => $this->post('papa')
        ];

        if ($this->member->createmember($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new data created.'
            ], REST_Controller::HTTP_CREATED);
        }else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put() {
        $id = $this->put('id');
        $data = [
            'name' => $this->put('name'),
            'gen' => $this->put('gen'),
            'debut_date' => $this->put('debut_date'),
            'debut_video' => $this->put('debut_video'),
            'yt_channel' => $this->put('yt_channel'),
            'twitter' => $this->put('twitter'),
            'mama' => $this->put('mama'),
            'papa' => $this->put('papa')
        ];

        if ($this->member->updatemember($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data updated.'
            ], REST_Controller::HTTP_OK);
        }else {
            $this->response([
                'status' => false,
                'message' => 'failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}