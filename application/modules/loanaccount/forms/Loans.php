<?php
class Loanaccount_Form_Loans extends Zend_Form 
{
    public function init() 
    {
    }
    public function __construct($minimumDeposit,$requetloan,$maxDeposite,$ID,$code,$app,$messageerr) 
    {
        parent::__construct($minimumDeposit,$requetloan,$maxDeposite,$ID,$code,$app);
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
       	$formfield = new App_Form_Field ();
        $amount = $formfield->field('Text','amount','','','txt_put amountclass','',true,'','','','','',0,$requetloan);
        $amount->addValidators(array(array('Float'),
                               array('GreaterThan',false,array($minimumDeposit-.0001,
                                     'messages' => array('notGreaterThan' => 'Minimum 
                                      Amount To open a loan account ='.$minimumDeposit))),
                               array('LessThan',false,array($maxDeposite+1,
                                     'messages' => array('notLessThan' => $messageerr)))
                               ));
        $date = $formfield->field('Text','date','','','txt_put','',true,'','','','','',0,0);
//         $date = new ZendX_JQuery_Form_Element_DatePicker('date');
//         $date->setAttrib('class', 'txt_put');
//         $date->setJQueryParam('dateFormat', 'yy-mm-dd');
//         $date->setRequired(true);
        $installments = $formfield->field('Select','installments','','','txt_put getinterest','',true,'','','','','',0,0);
        $installments->setAttrib('onchange','getInterests(this.value,"'.$app.'",'.base64_decode($ID).')');
        $interest = $formfield->field('Text','interest','','','txt_put','',true,'','','','','',0,0);
        $interest->setAttrib('size', '6');
        $interest->setAttrib('readonly', 'true');
        $interesttype = $formfield->field('Select','interesttype_id','','','txt_put','',true,'','','','','',0,0);
//         $fee = new Zend_Form_Element_MultiCheckbox('fee');
//         $fee->setRequired(true);
//         $fee->setAttrib('class', 'txt_put getamount');
//         $fee->removeDecorator('DtDdWrapper'); 
//         $fee->removeDecorator('HtmlTag');
//         $fee->setSeparator(" ");
        //$fee->removeDecorator('br');
  //      $fee->removeDecorator('label');
//        $savingAccount = $formfield->field('Select','savingAccount','','','txt_put','',true,'','','','','',0,0);
        $fundings = $formfield->field('Select','fundings','','','txt_put','',true,'','','','','',0,0);
        $fundings->addMultiOption('','Select...');
        $fundings->addMultiOption('1','funders');
        $fundings->addMultiOption('0','group');
        $fundings->setAttrib('onchange','displayRow(this.value)');
        $funders = $formfield->field('Radio','funders','','','txt_put','',false,'','','','','',0,0);
        $funders->setAttrib('size', '8');
        $funders->setSeparator(" ");

        //hidden feilds
	$path = $formfield->field('Hidden','path','','','pathid','',false,'','','','','',0,$app);
        $productid=$formfield->field('Hidden','productid','','','productid','',false,'','','','','',0,base64_decode($ID));
	$code = $formfield->field('Hidden','code','','','','',false,'','','','','',0,$code);
	$Id = $formfield->field('Hidden','Id','','','','',false,'','','','','',0,$ID);
	$submit = $formfield->field('Submit','Submit','','','','',false,'','','','','',0,0);
	$Yes = $formfield->field('Submit','Yes','','','','',false,'','','','','',0,0);
	$back = $formfield->field('Submit','Back','','','','',false,'','','','','',0,0);
        $this->addElements(array($submit,$amount,$installments,$interest,$interesttype,$fundings,$funders,$productid,$path,$code,$Id,$date,$back,$Yes));
    }
}
