<?php
declare(strict_types=1);

/**
 * This file is part of the c2system Base System.
 *
 * (c) cleartwo deployment Team <support@cleartwo.co.uk>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Controllers;

use Models\Accounts\BookedProducts;
use Models\Accounts\Cars;
use Models\Accounts\Leads;
use Models\Accounts\Options;
use Models\Accounts\Package;
use Models\Accounts\Accounts;
use Models\Accounts\ActivityLeads;
use Models\Accounts\Productnew;
use Models\Accounts\Products;
use Models\Accounts\ProductTypes;
use Models\Accounts\ProductTypeService;
use Models\Accounts\Services;
use Models\Inventory\Product;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;


use function Amp\Iterator\toArray;


/**
 * Display the default index page.
 */
class ApiController extends Controller
{
    protected $_isJsonResponse = false;

    // Call this func to set json response enabled
    public function setJsonResponse()
    {
        $this->view->disable();

        $this->_isJsonResponse = true;
        $this->response->setContentType('application/json', 'UTF-8');
    }

    // After route executed event
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        if ($this->_isJsonResponse) {
            $data = $dispatcher->getReturnedValue();
            if (is_array($data)) {
                $data = json_encode($data);
            }

            $this->response->setContent($data);
        }
    }


    /**
     * Default action.
     */
    public function getcarAction()
    {
        $this->view->disable();
        $id = $this->request->getPost('user_id');
        $get = Leads::find(
            [
                'conditions' => 'leadid = ?1 ',
                'bind' => [
                    1 => $id,
                ]
            ]
        );

        if ($id) {
            $leaddetail=array();
            if(isset($get[0]))
            {
            $leaddetail=$get[0]->lead;
            }
            foreach ($get as $key => $value) {
                if ($value->cars instanceof Cars) {
                    if ($value->cars->deleted == "" && $value->cars->deactivate == "") {
                        $a[] = $value->cars->toArray();
                    }
                }
            }
            if($a)
            {
            $a =  array_unique($a, SORT_REGULAR);
            }
            foreach ($a as $key=>$value)
            {
                $final[]=$value;
            }
            $b["car"]= $final;
            $b["customerdetail"]=$leaddetail;
            return json_encode($b);
        }
    }

    /**
     * Default action.
     */
    public function getleadsAction()
    {
        $this->view->disable();
        $id = $this->request->getPost('user_id');
        if ($id) {
            $get = Leads::find(
                [
                    'conditions' => 'accountid = ?1 ',
                    'bind' => [
                        1 => $this->request->getPost('user_id'),
                    ]
                ]
            );
			$a=array();
            foreach ($get as $key => $value) {
                $d['id'] = $value->id;
                $d['name'] = $value->lead->fname . ' ' . $value->lead->lname . '(' . $value->lead->email . ')';
                $d['leadid'] = $value->leadid;
                $a[] = $d;
            }

            $temp = array_unique(array_column($a, 'leadid'));
            $a = array_intersect_key($a, $temp);
			$final=array();
			foreach ($a as $key=>$value)
            {
                $final[]=$value;
            }
            return json_encode($final);
        }
    }
	
	public function getaccountsAction()
	{
		 $this->view->disable();
            $get = Accounts::find();

            foreach ($get as $key => $value) {
                $d['id'] = $value->id;
                $d['name'] = $value->companyname .  '(' . $value->companyemail . ')';
                 $a[] = $d;
            }

            $temp = array_unique(array_column($a, 'id'));
            $a = array_intersect_key($a, $temp);

            return json_encode($a);
        
	}

    public function cardetailAction()
    {
        $this->view->disable();
         $carid=$this->request->getPost('id');
        $car=Cars::findFirst($carid);
       echo json_encode($car);
    }
    public function getproductsAction()
    {
        if ($this->request->isPost()) {
            $this->view->disable();
            $id = $this->request->getPost('user_id');
            $res = "";
            if ($id) {
                $bookingnew = $this->request->getPost('newbookingdirect');
                if (isset($bookingnew) == 1) {
                    $gt = new ProductTypes();
                    $getProducttypes = $gt->getuniqueproducttyepservice();
                } else {
                    $getProducttypes = ProductTypeService::find(
                        [
                            'conditions' => 'serviceid = ?1  ',
                            'bind' => [
                                1 => $id,
                            ]
                        ]
                    );
                }
                if ($getProducttypes) {
                    $res .= ' <button type="button" class="btn btn-secondary table' . $id . '" id="serviceidaddproduct" data-service-id="' . $id . '">
    Add new Product
</button>
<table id="table' . $id . '" data-duration="' . $getProducttypes[0]->producttypedata->service->duration . '"
       class="leadproducts table table-sm table-bordered datatable datatable-bordered datatable-head-custom"
       id="kt_datatable" style="margin-top: 13px !important">
    <thead class="thead-light">
    <tr>
        <th width="12%">Service</th>
        <th>Product Type</th>
        <th width="12%">Prodcut Name</th>
        <th class="qty">Qty.</th>
        <th width="14%" class="size">Unit</th>
        <th width="14%" class="size">size</th>
        <th width="14%" class="size">Total Amount</th>
        <th width="14%" class="size"></th>
    </tr>
    </thead>
    <tbody>';


                    foreach ($getProducttypes as $key => $value) {

                        if ($value->serviceid == $id) {
                            $res .= '<tr id="producttype' . $value->producttypedata->producttype->id . '">        			
                	        <td width="12%">' . $value->producttypedata->service->name . ' </td>
                          <td width="12%">' . $value->producttypedata->producttype . ' </td>
        				<td><select name="producttype" id="producttype" class="form-control">';
                            foreach ($value->producttypedata->product as $key1 => $value1) {
                                if ($value1->deleted != 1) {
                                    if (!isset($firstelement) || $firstelement == 0) {
                                        $firstelement = $value1;
                                    }
                                    $res .= '<option data-product-type="' . $value1->id . '"value="' . $value1->name . '">' . $value1->name . '</option>';
                                }
                            }
                            $res .= "</select></td>";

                            $res .= '<td width="14%"><input type="hidden" value="' . $firstelement->id . '" name="product[' . $value->producttypedata->service->id . '][' . $firstelement->id . '][id]" class="id"><input min="0" type="number" class=" qty form-control" data-actual-amount="' . $firstelement->extendedamount . '" value="' . $firstelement->qty . '" name="product[' . $value->producttypedata->service->id . '][' . $firstelement->id . '][qty]"></td>
        				<td><input type="number" class="unit form-control" min="0" value="' . $value->producttypedata->id . '" name="product[' . $value->producttypedata->service->id . '][' . $firstelement->id . '][unit]"></td>
        				<td width="14%"><input type="text" value="' . $firstelement->size . '" class="form-control" name="product[' . $value->producttypedata->service->id . '][' . $firstelement->id . '][size]"> </td>
        				<td width="12%" class="productprice"> <input type="text" class="form-control extendendamount" value="' . $firstelement->extendedamount . '" name="product[' . $value->producttypedata->service->id . '][' . $firstelement->id . '][extendedamount]"></td>
        				<td><span  class="removerowbookingproducts   btn btn-danger">Remove</span></td>
        			</tr>';
                            echo $res;
                            $firstelement = 0;
                            $res = "";
                        }
                    }
                    $res .= '</tbody>
        </table>';
                    return $res;

                }
            }
        }
    }

    public function getcompanyserviceAction()
    {
        $this->view->disable();
        $id = $this->request->getPost('value');
        if ($id) { 
            $get = Options::find(
                [
                    'conditions' => 'company = ?1 ',
                    'bind' => [
                        1 => $this->request->getPost('value'),
                    ]
                ]
            );
			 
            foreach ($get as $key => $value) {
                $d['id'] = $value->id;
                $d['name'] = $value->value;
                $a[] = $d;
            }

            return json_encode($a);

        }
    }

    public function getproductsbytypeAction()
    {
        $this->view->disable();
        $id = $this->request->getPost('producttype');
        if ($id) {

            $bookingid = $this->request->getPost('bookingid');
            $get = BookedProducts::findFirst(
                [
                    'conditions' => 'bookingid = ?1 AND productid=?2',
                    'bind' => [
                        1 => $bookingid,
                        2 => $id
                    ]
                ]
            );
            if (count($get) != 0) {
                $res['id'] = $get->productid;
                $res['bookingid'] = $get->bookingid;
                $res['serviceid'] = $get->serviceid;
                $res['extendedamount'] = $get->extendedamount;
                $res['qty'] = $get->qty;
                $res['unit'] = $get->unit;
                $res['size'] = $get->size;
                $get = "";
                $get = $res;
            }
            if (count($get) == 0) {
                $gt = new ProductTypes();
                $getProducttypes = $gt->getuniqueproducttyepservice();
                foreach ($getProducttypes as $key => $value) {
                    foreach ($value->producttypedata->product as $key1 => $value1) {
                        if ($value1->id == $id) {
                            $res['id'] = $value1->id;
                            $res['serviceid'] = $value->serviceid;
                            $res['extendedamount'] = $value1->extendedamount;
                            $res['qty'] = $value1->qty;
                            $res['unit'] = $value1->unit;
                            $res['size'] = $value1->size;
                        }
                    }
                }

//             }
//                 $get = Products::findFirst(
//                    [
//                        'conditions' => 'id = ?1 ',
//                        'bind' => [
//                            1 => $id,
//                        ]
//                    ]
//                );
            }
            return json_encode($res);
        }
    }

    public function existingproductAction()
    {
        $id = $this->request->getPost('productid');
        $loadproduct = Products::find(
            [
                'conditions' => 'producttype = ?1 AND leadid IS Null  ',
                'bind' => [
                    1 => $id,
                ]
            ]
        );
        return json_encode($loadproduct);
        $this->view->disable();
    }

    public function productdetailsAction()
    {
        $id = $this->request->getPost('productid');
        $loadproduct = Products::FindFirst(
            [
                'conditions' => 'id = ?1 ',
                'bind' => [
                    1 => $id,
                ]
            ]
        );
        $data = $loadproduct->toArray();
        $data["detail"] = array();
        if ($loadproduct->stock) {
            $data["detail"] = $loadproduct->stock->toArray();
        }
        return json_encode($data);
        $this->view->disable();
    }

    public function getrelatedcategoryAction()
    {
        $id = $this->request->getPost('serviceid');
        $get = Options::findFirst($id);
        $opgroup = strtolower(str_replace(' ', '', $get->key)) . 'category';
        $sgparameters['conditions'] = "(opgroup='$opgroup') AND is_deleted IS NULL AND status = 0";
        $category = Options::find($sgparameters);
        $d = "";
        foreach ($category as $item => $value) {
            $d .= "<option value='" . $value->id . "'>$value->value</option>";
        }
        echo $d;
        die();
    }

    public function getrelatedproductmadeupAction()
    {
//        $id=$this->request->getPost('categoryid');
//         $products = Productnew::find("categoryid=$id");
        $products = Productnew::find();
        $d = "";
        foreach ($products as $item => $value) {
            $d .= "<option value='" . $value->id . "'>$value->name</option>";
        }
        echo $d;
        die();
    }

    public function upgradesproductAction()
    {
        $id = $this->request->getPost('categoryid');
        $products = Productnew::find();
        $d = "";
        foreach ($products as $item => $value) {
            if ($value->id == $id) {
                $d .= "<option value='" . $value->id . "'>$value->name</option>";
                $category = $value->categoryname->value;
            }
        }
        $data['product'] = $d;
        $data['category'] = $category;
        echo json_encode($data);
        die();
    }


    public function madeupproductfunctionAction()
    {
        $id = $this->request->getPost('categoryid');
        $products = Productnew::find();
        $d = "";
        $category = "";
        foreach ($products as $item => $value) {
            if ($value->id == $id) {
                $d .= "<option value='" . $value->id . "'>$value->name</option>";
                $category = $value->categoryname->value;
            }
        }
        $data['product'] = $d;
        $data['category'] = $category;
        echo json_encode($data);
        die();

    }

    public function madeupproductlistAction()
    {
        $productid = $this->request->getPost('productid');
        $categoryid = $this->request->getPost('categoryid');

        $sgparameters['conditions'] = "prodcuctpackage='$productid' AND isupgrade=1";
        $products = Package::find($sgparameters);
        foreach ($products as $key => $value) {
            if ($value->productname->categoryid == $categoryid) {
                $d = $value->toarray();
                $d['detail'] = $value->productname->toarray();
                $dd[] = $d;
            }
        }
        $ds = "";
        foreach ($dd as $key => $value) {
            $ds .= "<option value='" . $value['id'] . "'>" . $value['detail']['name'] . "</option>";
        }

        echo $ds;
        $this->view->disable();
    }

    public function addNewProductBookingAction()
    {
        $id = $this->request->getPost('productid');
        $sgparameters['conditions'] = "ispackage=1 AND id=$id";
        $productlist = Productnew::find($sgparameters);
        $d = "";
        $package = new Package();
        foreach ($productlist as $key3 => $value3) {
            $d .= '<tr class="productlist' . $value3->id . '">
                        <td id="' . $value3->id . '" >' . $value3->name . '</td>
                        <td> ';
            foreach ($value3->prodcuctpackage as $Key => $value) {
                if ($value->isupgrade != 1) {
                    $d .= $package::madeupproductlist($value3->id, $value->productname->categoryid);
                }
            }
            $d .= ' </td>
                        <td>' . $value3->quantity . '</td>
                        <td class="text-right" data-cost-value="' . $value3->rrp . '"><div>&pound; ' . $value3->rrp . '</div></td>
                    </tr>';
        }
        echo $d;
        $this->view->disable();
    }

    public function addupgradeproductbookingAction()
    {

        $productid = $this->request->getPost('productidmodal');
        $categoryid = $this->request->getPost('categoryid');
        $productselected = $this->request->getPost('upgradeproducts');

        $sgparameters['conditions'] = "productpackage='$productid' AND isupgrade=1";
        $products = Package::find($sgparameters);
        foreach ($products as $key => $value) {
            if ($value->productname->categoryid == $categoryid && in_array($value->id, $productselected)) {
                $d = $value->toarray();
                $d['detail'] = $value->productname->toarray();
                $dd[] = $d;
            }
        }
        $d = "";

        foreach ($dd as $key1 => $value1) {

            $d .= '<tr class="productlist42">
                        <td> </td>
                        <td> <span  class="productupgradebtn1 btn-primary">' . $value1['detail']['name'] . '</span>  </td>
                        <td>' . $value1['quantity'] . '</td>
                        <td data-cost-value="' . $value1['cost'] . '">£ ' . $value1['cost'] . '</td>
                    </tr>';
        }

        echo $d;
        die();
    }


    /*
      * Duplicate product
     */

    public function duplicateAction($id)
    {
        $d=Productnew::findFirst($id);
         $service = new Productnew();

        $service->serviceid  = $d->serviceid;
        $service->categoryid  = $d->categoryid;
        $service->name  = $d->name;
        $service->quantity  = $d->quantity;
        $service->rrp  = $d->rrp;
        $service->supplierid  = $d->supplierid;
        $service->ispackage  = $d->ispackage;
        $service->save();

         if($d->ispackage==1)
        {

            $ispackage  = $d->prodcuctpackage;
            foreach ($ispackage as $key=>$value) {

                /*
                 * Add Package by Admin
                */

                $package = new Package();
                $package->prodcuctpackage = $service->id;
                $package->relatedproductid = $value->relatedproductid;
                $package->quantity = $value->quantity;
                if($value->isupgrade==1)
                {
                     $package->isupgrade = 1;
                     $package->cost = $value->cost;
                }
                $package->save();
            }

        }



        $this->flashSession->success('Product Created Successfully');
        return $this->response->redirect("service/detail/$service->id");

    }




    public function getselectedupgradedetailAction()
    {
        $this->view->disable();
         $productselected = $this->request->getPost('relatedproductid');

        $sgparameters['conditions'] = "id='$productselected'";
        $products = Package::findFirst($sgparameters);
        if($products instanceof Package) {
            $da = $products->toarray();
            $da['detail'] = $products->productname->toarray();
        }
        echo json_encode($da);
    }

    public function getcarapiAction()
    {
        if($this->request->isPost())
        {
        $curl = curl_init();
        $vrm = $this->request->getPost('registration');
        $ApiKey = "4ca89973-9723-4156-aa19-830920038150";
        $url = "https://uk1.ukvehicledata.co.uk/api/datapackage/%s?v=2&api_nullitems=1&key_vrm=%s&auth_apikey=%s";
        $url = sprintf($url, "VehicleData", $vrm, $ApiKey);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if ($error) {
            echo "cURL Error: " . $error;
        } else {
            $respons1= json_decode($response,true);
            $res['status']=$respons1['Response']['StatusCode'];
            $res['VehicleRegistration']=$respons1['Response']['DataItems']['VehicleRegistration'];
            $res['SmmtDetails']=$respons1['Response']['DataItems']['SmmtDetails'];
            echo json_encode($res);
         }
        $this->view->disable();
    }
    }
	
	public function updatetaskstatusAction($id)
	{
		$data=ActivityLeads::findFirst($id);
		if($data instanceof ActivityLeads)
		{
			$data->status=1;
			$data->update();
		     $this->flashSession->success('Task Completed Successfully');
            return $this->response->redirect($_SERVER['HTTP_REFERER']);
		}
		
			
	}
}
