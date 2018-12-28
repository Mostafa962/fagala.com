<?php
class ControllerCostsCost extends Controller {
	//show Costs List
	 public function index(){
		$this->load->language('costs/cost');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('costs/cost');
		$this->getList();
	}
	//Add New Cost
	public function add() {
		$this->load->language('costs/cost');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('costs/cost');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_costs_cost->addCost($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url));
		}
		$this->getForm();
	}
	//Edit Existing Cost
	public function edit() {
		$this->load->language('costs/cost');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('costs/cost');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_costs_cost->editCost($this->request->get['cost_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url));
		}
		$this->getForm();
	}
	//Delete Costs
	public function delete() {
		$this->load->language('costs/cost');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('costs/cost');
		//Multi Delete
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $cost_id) {
				$this->model_costs_cost->deleteCost($cost_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url));
		}
		//Single Delete
		elseif (isset($this->request->post['deleteCost']) && $this->validateDelete()) {
				$cost_id = $this->request->post['cost_id'];
				$this->model_costs_cost->deleteCost($cost_id);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url));
		}
		$this->getList();
	}
	//Ensure That Admin has permission to delete items
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'costs/cost')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	//To show List in Table
	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'description';
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url)
		);
		$data['add'] = $this->url->link('costs/cost/add', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('costs/cost/delete', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['repair'] = $this->url->link('costs/cost/repair', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['costs'] = array();
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$cost_total = $this->model_costs_cost->getTotalCosts();
		$results = $this->model_costs_cost->getCosts($filter_data);
		foreach ($results as $result) {
			$data['costs'][] = array(
				'cost_id' => $result['cost_id'],
				'description'        => $result['description'],
				'value'  	=> $result['value'],
				'edit'        => $this->url->link('costs/cost/edit', 'user_token=' . $this->session->data['user_token'] . '&cost_id=' . $result['cost_id'] . $url),
				'delete'      => $this->url->link('costs/cost/delete', 'user_token=' . $this->session->data['user_token'] . '&cost_id=' . $result['cost_id'] . $url)
			);
		}
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $cost_total,
			'page'  => $page,
			'limit' => $this->config->get('config_limit_admin'),
			'url'   => $this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		));

		$data['results'] = sprintf($this->language->get('text_pagination'), ($cost_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($cost_total - $this->config->get('config_limit_admin'))) ? $cost_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $cost_total, ceil($cost_total / $this->config->get('config_limit_admin')));
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('costs/Show_Costs', $data));
	}
	//show Form for edit and delete
	protected function getForm() {
		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');
		$this->document->addScript('view/javascript/additional-methods.min.js');
		$this->document->addScript('view/javascript/jquery.validate.min.js');
		$this->document->addScript('view/javascript/validation.js');

		$data['text_form'] = !isset($this->request->get['cost_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url)
		);
		if (!isset($this->request->get['cost_id'])) {
			$data['action'] = $this->url->link('costs/cost/add', 'user_token=' . $this->session->data['user_token'] . $url);
		} else {
			$data['action'] = $this->url->link('costs/cost/edit', 'user_token=' . $this->session->data['user_token'] . '&cost_id=' . $this->request->get['cost_id'] . $url);
		}
		$data['cancel'] = $this->url->link('costs/cost', 'user_token=' . $this->session->data['user_token'] . $url);
		if (isset($this->request->get['cost_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$cost_info = $this->model_costs_cost->getCost($this->request->get['cost_id']);
		}
		//data for edit
		if (isset($this->request->post['cost_description'])) {
			$data['cost_description'] = $this->request->post['cost_description'];
		} elseif (!empty($cost_info)) {
			$data['cost_description'] = $cost_info['description'];
		} else {
			$data['cost_description'] = '';
		}

		if (isset($this->request->post['cost_value'])) {
			$data['cost_value'] = $this->request->post['cost_value'];
		} elseif (!empty($cost_info)) {
			$data['cost_value'] = $cost_info['value'];
		} else {
			$data['cost_value'] = '';
		}
		//
		$data['user_token'] = $this->session->data['user_token'];
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$this->load->model('design/layout');
		$data['layouts'] = $this->model_design_layout->getLayouts();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('costs/Costs_Forms', $data));
	}
}
