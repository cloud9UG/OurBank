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
class Fundings_Form_Fundings extends ZendX_JQuery_Form 
{
    public function init() 
    {
	$formfield = new App_Form_Field ();
        $name = $formfield->field('Text','name','','','mand','Funding name',true,'','','','','',1,0);
        $funderId = $formfield->field('Select','funder_id','','','mand','Funder name',true,'','','','','',1,0);
        $interest = $formfield->field('Text','interest','','',' ','Interest %',false,'','','','','',1,0);
        $currencyId = $formfield->field('Select','currency_id','','','mand','Funding currency',true,'','','','','',1,0);
        $amount = $formfield->field('Text','amount','','','mand digits','Funding amount Rs',true,'','','','','',1,0);
        
        $exchangerate = $formfield->field('Text','exchangerate','','','mand','Funding exchange rate',true,'','','','','',1,0);
/*        $date = new ZendX_JQuery_Form_Element_DatePicker('date');
        $date->setAttrib("class","mand");
        $date->setJQueryParam("year", 'true');
        $date->setJQueryParam('changeMonth', 'true');
        $date->setJQueryParam('changeYear', 'true'); */       
        $beginingDate = $formfield->field('Text','beginingdate','','','','Funding period from',false,'','','','','',1,0);
        $beginingDate->setAttrib('autocomplete','off'); 
        $closingDate = $formfield->field('Text','closingdate','','','','Funding period to',false,'','','','','',1,0);
        $closingDate->setAttrib('autocomplete','off'); 
 // Hidden Feilds 
	$id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,0);
	$createdBy = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,1);
        $createdDate = $formfield->field('Hidden','created_date','','','','',false,'','','','','',0,date("y/m/d H:i:s"));
        $this->addElements(array($funderId,$name,
									 $amount,$interest,
                                     $currencyId,$exchangerate,
									 $beginingDate,$closingDate,
                                     $id,$createdBy,
									 $createdDate));
    }
}