<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php
class Penalty_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle = "Penalty";

        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->username = $this->view->globalvalue[0]['username'];
        $this->view->createdby = $this->view->globalvalue[0]['id'];
// 		if (($this->view->globalvalue[0]['id'] == 0)) {
// 			$this->_redirect('index/logout');
// 		}
        $this->view->adm = new App_Model_Adm();
        $this->view->dateconvert = new Creditline_Model_dateConvertor();

        $test = new DH_ClassInfo(APPLICATION_PATH . '/modules/penaltyindex/controllers/');
        $module = $test->getControllerClassNames();
        $modulename = explode("_", $module[0]);
        $this->view->modulename = strtolower($modulename[0]);
    }

    public function indexAction() {
    }

    public function penaltyaddAction() {
                //Acl
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
// 		if (($checkaccess != NULL)) {

                //add
        $form=$this->view->penaltyform=new Penalty_Form_Penalty();
        $creditline = $this->view->adm->viewRecord("ob_creditline","id","DESC");
        foreach($creditline as $creditline){
            $form->creditlinename->addMultiOption($creditline['id'],$creditline['name']);
        }
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
            $formData = $this->_request->getPost();
                if ($form->isValid($formData)) {
                    $formdata1=array('name'=>$formData['penaltyname'],'penalty_per_delay'=>$formData['penalty_per_delay'],'interest_of_delay'=>$formData['interest_of_delay'],'creditline_id'=>$formData['creditlinename'],'status'=>$formData['status'],'created_by'=>$this->view->createdby);
                    $id = $this->view->adm->addRecord("ob_penalty",$formdata1);
                    $this->_redirect('/penaltyindex');
                }
        }
// 		} else {
// 		$this->_redirect('index/index');
// 		}
        }

        public function penaltyeditAction() {
                //Acl
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
// 		if (($checkaccess != NULL)) {

                //edit
            $form=$this->view->penaltyform=new Penalty_Form_Penalty();
            
            $creditline = $this->view->adm->viewRecord("ob_creditline","id","DESC");
            foreach($creditline as $creditline){
                $form->creditlinename->addMultiOption($creditline['id'],$creditline['name']);
            }

            $this->view->id=$id=$this->_request->getParam('penalty_id');
            $fetchpenalty=new Penalty_Model_Penalty();
            $fetchpenalty2=$fetchpenalty->fetchpenaltydetailsforID($id);
            foreach($fetchpenalty2 as $fetchpenalty1) {
                $this->view->penaltyform->penaltyname->setValue($fetchpenalty1['name']);
                $this->view->penaltyform->creditlinename->setValue($fetchpenalty1['creditline_id']);
                $this->view->penaltyform->penalty_per_delay->setValue($fetchpenalty1['penalty_per_delay']);
                $this->view->penaltyform->interest_of_delay->setValue($fetchpenalty1['interest_of_delay']);
                $this->view->penaltyform->status->setValue($fetchpenalty1['status']);

                $formdata2=array('id'=>$fetchpenalty1['id'],'name'=>$fetchpenalty1['name'],'creditline_id'=>$fetchpenalty1['creditline_id'],'penalty_per_delay'=>$fetchpenalty1['penalty_per_delay'],'interest_of_delay'=>$fetchpenalty1['interest_of_delay'],'status'=>$fetchpenalty1['status'],'created_by'=>$fetchpenalty1['created_by'],'created_date'=>$fetchpenalty1['created_date']);
            }
    
            if($this->_request->isPost() && $this->_request->getPost('Update')) {
                $id = $this->_getParam('penalty_id');
                $formData = $this->_request->getPost();
                if ($form->isValid($formData)) {
                    $formdata1=array('name'=>$formData['penaltyname'],'creditline_id'=>$formData['creditlinename'],'penalty_per_delay'=>$formData['penalty_per_delay'],'interest_of_delay'=>$formData['interest_of_delay'],'status'=>$formData['status'],'created_by'=>$this->view->createdby);
                    $this->view->adm->updateLog("ob_penalty_log",$formdata2,$this->view->createdby);
                    $this->view->adm->updateRecord("ob_penalty",$id,$formdata1);
                    $this->_redirect('/penaltyindex');
                }
            }

// 		} else {
// 		$this->_redirect('index/index');
// 		}
        }

        public function penaltyviewAction() {
        }

        public function penaltydeleteAction() {
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Activity',$this->view->globalvalue[0]['name'],'activityeditAction');
// 		if (($checkaccess != NULL)) {
            $form = new Penalty_Form_Delete();
            $this->view->form = $form;
            $this->view->id = $this->_getParam('penalty_id');
            if($this->_request->isPost() && $this->_request->getPost('Delete')) {
                $formdata = $this->_request->getPost();
                if($form->isValid($formdata)) {
                    $redirect = $this->view->adm->deleteAction("ob_penalty",$this->view->modulename,$this->view->id);
                    $this->_redirect("/".$redirect);

                }
            }


// 		} else {
//              $this->_redirect('index/error');
// 		}
        }
}
