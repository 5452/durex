<?php


/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Sales orders controller
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */

define("TIMESTEMP",9000000);
define("PCKEY",'djpc123');
define("BCKEY",'djbc123');
define("SCKEY",'djsc123');

class Mage_Sales_OrderController extends Mage_Sales_Controller_Abstract
{

	public function indexAction()
	{
		 

		$_SOAP = new SoapClient('http://124.205.25.148/m/index.php/api/soap/?wsdl');
		$sessionId = $_SOAP->login('Henry', '000000');
		
		$orderList = $_SOAP->call($sessionId, 'sales_order.list',array(array('created_at'=>array
				('from'=>$formTime,'to'=>$toTime2))) );
		foreach($orderList as $order){
			echo var_export($order);
			break;
		}
// 		$filters = array(
// 				'sku' => array('like'=>'%t%')
// 		);

// 		$products = $proxy->call($sessionId, 'product.list', array($filters));

// 		var_dump($products);

		$_SOAP->endSession($sessionId);

	    return $sessionId;
	}
	public function test()
	{

		return 1;

	}

    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     */
    public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();

        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    /**
     * Customer order history
     */
    public function historyAction()
    {
    	$this->loadLayout();
        $this->_initLayoutMessages('catalog/session');

        $this->getLayout()->getBlock('head')->setTitle($this->__('My Orders'));

        if ($block = $this->getLayout()->getBlock('customer.account.link.back')) {
            $block->setRefererUrl($this->_getRefererUrl());
        }
        $this->renderLayout();
    }

    /**
    Summary ：解析产品XML.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function ParseProductXML1($productDetail)
    {
    	header("Content-Type: text/html; charset=utf-8");
    	$prductList = array();

    	$productDetail = "<?xml version='1.0' encoding='gb2312' ?>
    			<order>
    				<id>UC123456</id>
    					<product>
			    			<sku>101</sku>
			    			<type>AA</type>
			    			<name>定双人盒 (One box with 2 zodiac signs)</name>
			    			<zs>2</zs>
			    			<bg_type>1</bg_type>
			    			<bg_option>1</bg_option>
			    			<text>Hi...</text>
			    			<barcode></barcode>
			    			<qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
		    			</product>
		    			<product>
			    			<sku>102</sku>
			    			<type>AB</type>
			    			<name>双人双盒 (Two boxes, each box has 1 corresponding zodiac sign and the corresponding background)</name>
			    			<zs1>1</zs1>
			    			<zs2>2</zs2>
			    			<bg_type1>1</bg_type1>
			    			<bg_type2>1</bg_type2>
						    <bg_option1>1</bg_option1>
						    <bg_option2>2</bg_option2>
						    <text1>Hi honey...</text1>
						    <text2>Hi darling...</text2>
						    <barcode1></barcode1>
						    <barcode2></barcode2>
						    <qrcode1>http://pppcs.durex.com.cn/api/app?p1=....</qrcode1>
						    <qrcode2>http://pppcs.durex.com.cn/api/app?p1=....</qrcode2>
					  </product>
					  <product>
						    <sku>103</sku>
						    <type>C</type>
						    <name>定制单人盒子(One box for one single with 1 zodiac sign)</name>
						    <zs>1</zs>
						    <bg_type>1</bg_type>
						    <bg_option>1</bg_option>
						    <text>Hi...</text>
						    <barcode></barcode>
						    <qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
					  </product>
	    			  <product>
						    <sku>104</sku>
						    <type>D</type>
						    <name>定大师盒 (One box for one single with 1 master design)</name>
						    <design_option>1</design_option>
						    <text>Hi...</text>
						    <barcode></barcode>
						    <qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
					  </product>
    			</order>";

    	$Order = simplexml_load_string($productDetail);

    	foreach($Order as $product)   //获取XML对象里面的每一个子节点，也是一个类似于数组的对象
        {
        	if(count($product) != 0)
        	{
	        	$PM = new ProductModel();
	        	$PM->sku = (string) $product->sku;

		    	$PM->type = (string) $product->type;
		    	$PM->name = (string) $product->name;
		    	$PM->zs = (string) $product->zs;
		    	$PM->zs1 = (string) $product->zs1;
		    	$PM->zs2 = (string) $product->zs2;
		    	$PM->bg_type = (string) $product->bg_type;
		    	$PM->bg_option = (string) $product->bg_option;
		    	$PM->text = (string) $product->text;
		    	$PM->qrcode = (string) $product->qrcode;
		    	$PM->bg_type1 = (string) $product->bg_type1;
		    	$PM->bg_type2 = (string) $product->bg_type2;
		    	$PM->bg_option1 = (string) $product->bg_option1;
		    	$PM->bg_option2 = (string) $product->bg_option2;
		    	$PM->text1 = (string) $product->text1;
		    	$PM->text2 = (string) $product->text2;
		    	$PM->qrcode1 = (string) $product->qrcode1;
		    	$PM->qrcode2 = (string) $product->qrcode2;

		    	$time =time();
		    	$code=date('Y',$time);
		    	$code=substr($code,2);
		    	$code +=date('m',$time);
		    	$codeM = $code;

		    	$PM->barcode='103601'.($codeM.date('dHis',$time));
		    	$PM->barcode1='103601'.(($codeM+12).date('dHis',$time));
		    	$PM->barcode2='103601'.(($codeM+13).date('dHis',$time));
		    	array_push($prductList,$PM);
        	}
        }

        return $prductList;
    }

    /**
     Summary ：解析产品XML.
     Author  ：Henry.
     Add Time：2014-09-05.
     **/
    public function ParseProductXML($productDetail)
    {
    	header("Content-Type: text/html; charset=utf-8");
    	$prductList = array();

    	$productDetail = "<?xml version='1.0' encoding='gb2312' ?>
    			<order>
    				<id>UC123456</id>
    					<product>
			    			<sku>101</sku>
			    			<type>AA</type>
			    			<name>定双人盒 (One box with 2 zodiac signs)</name>
			    			<zs>2</zs>
			    			<bg_type>1</bg_type>
			    			<bg_option>1</bg_option>
			    			<text>Hi...</text>
			    			<barcode></barcode>
			    			<qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
		    			</product>
		    			<product>
			    			<sku>102</sku>
			    			<type>AB</type>
			    			<name>双人双盒 (Two boxes, each box has 1 corresponding zodiac sign and the corresponding background)</name>
			    			<zs1>1</zs1>
			    			<zs2>2</zs2>
			    			<bg_type1>1</bg_type1>
			    			<bg_type2>1</bg_type2>
						    <bg_option1>1</bg_option1>
						    <bg_option2>2</bg_option2>
						    <text1>Hi honey...</text1>
						    <text2>Hi darling...</text2>
						    <barcode1></barcode1>
						    <barcode2></barcode2>
						    <qrcode1>http://pppcs.durex.com.cn/api/app?p1=....</qrcode1>
						    <qrcode2>http://pppcs.durex.com.cn/api/app?p1=....</qrcode2>
					  </product>
					  <product>
						    <sku>103</sku>
						    <type>C</type>
						    <name>定制单人盒子(One box for one single with 1 zodiac sign)</name>
						    <zs>1</zs>
						    <bg_type>1</bg_type>
						    <bg_option>1</bg_option>
						    <text>Hi...</text>
						    <barcode></barcode>
						    <qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
					  </product>
	    			  <product>
						    <sku>104</sku>
						    <type>D</type>
						    <name>定大师盒 (One box for one single with 1 master design)</name>
						    <design_option>1</design_option>
						    <text>Hi...</text>
						    <barcode></barcode>
						    <qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
					  </product>
    			</order>";

    	$Order = simplexml_load_string($productDetail);

    	foreach($Order as $product)   //获取XML对象里面的每一个子节点，也是一个类似于数组的对象
    	{
    		if(count($product) != 0)
    		{
    			$PM = new ProductModel();
    			$PM->sku = (string) $product->sku;

    			$PM->type = (string) $product->type;
    			$PM->name = (string) $product->name;
    			$PM->zs = (string) $product->zs;
    			$PM->zs1 = (string) $product->zs1;
    			$PM->zs2 = (string) $product->zs2;
    			$PM->bg_type = (string) $product->bg_type;
    			$PM->bg_option = (string) $product->bg_option;
    			$PM->text = (string) $product->text;
    			$PM->qrcode = (string) $product->qrcode;
    			$PM->bg_type1 = (string) $product->bg_type1;
    			$PM->bg_type2 = (string) $product->bg_type2;
    			$PM->bg_option1 = (string) $product->bg_option1;
    			$PM->bg_option2 = (string) $product->bg_option2;
    			$PM->text1 = (string) $product->text1;
    			$PM->text2 = (string) $product->text2;
    			$PM->qrcode1 = (string) $product->qrcode1;
    			$PM->qrcode2 = (string) $product->qrcode2;

    			$time =time();
    			$code=date('Y',$time);
    			$code=substr($code,2);
    			$code +=date('m',$time);
    			$codeM = $code;

    			$PM->barcode='103601'.($codeM.date('dHis',$time));
    			$PM->barcode1='103601'.(($codeM+12).date('dHis',$time));
    			$PM->barcode2='103601'.(($codeM+13).date('dHis',$time));
    			array_push($prductList,$PM);
    		}
    	}

    	return $prductList;
    }

    /**
    Summary ：添加订单产品.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function addorderproduct($OrderId,$PMList,$connection)
    {
    	$tableName = 'sales_flat_order_item';
    	$length = count($PMList);
    	$reValue=true;

    	try
    	{
	    	for ($i=0; $i< $length; $i++)
	    	{
		    	$fields = array();
		    	//添加订单信息.
		    	$fields['order_id'] = $OrderId;
		    	$fields['product_id'] = $OrderId + (string)$i;
		    	$fields['sku'] = $PMList[$i]->sku;
		    	$fields['type'] = $PMList[$i]->type;
		    	$fields['name'] = $PMList[$i]->name;
		    	$fields['created_at'] = date('Y-m-d H:i:s',time());
		    	$fields['row_total']= 109;

		    	if($PMList[$i]->type != 'AB')
		    	{
		    		$fields['bg_type'] = $PMList[$i]->bg_type;
			    	$fields['bg_option'] = $PMList[$i]->bg_option;
			    	$fields['zs'] = $PMList[$i]->zs;
			    	$fields['text'] = $PMList[$i]->text;
			    	$fields['qrcode'] = $PMList[$i]->qrcode;
			    	$fields['barcode'] = $PMList[$i]->barcode;
			    	$fields['price']=$PMList[$i]->price;

			    	$connection->insert($tableName, $fields);
			    	$connection->commit();
			    }
		    	else
		    	{
		    		$fields['bg_type'] = $PMList[$i]->bg_type1;
		    		$fields['bg_option'] = $PMList[$i]->bg_option1;
		    		$fields['zs'] = $PMList[$i]->zs1;
		    		$fields['text'] = $PMList[$i]->text1;
		    		$fields['qrcode'] = $PMList[$i]->qrcode1;
		    		$fields['barcode'] = $PMList[$i]->barcode1;
		    		$fields['price']=$PMList[$i]->price1;

		    		$connection->insert($tableName, $fields);
		    		$connection->commit();

		    		$fields['product_id'] = $OrderId + (string)$i;
		    		$fields['bg_type'] = $PMList[$i]->bg_type2;
		    		$fields['bg_option'] = $PMList[$i]->bg_option2;
		    		$fields['zs'] = $PMList[$i]->zs2;
		    		$fields['text'] = $PMList[$i]->text2;
		    		$fields['qrcode'] = $PMList[$i]->qrcode2;
		    		$fields['barcode'] = $PMList[$i]->barcode2;
		    		$fields['price']=$PMList[$i]->price2;

		    		$connection->insert($tableName, $fields);
		    		$connection->commit();
		    	}
	    	}
	    }
    	catch (Exception $e)
    	{
    		$reValue=false;
    		print $e;
    	}

    	return $reValue;
    }

    /**
    Summary ：检查订单是否有效.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function isorderAction()
    {
    	$order_id  =	$_POST['p1'];
        $Timestamp =    $_POST['p2'];
        $Encrypt   =	$_POST['p3'];

        $returnValue = OrderState::Yes;


       //如果在时间戳范围内则进行验证及其订单入库操作.
       if(($Timestamp + TIMESTEMP) > time())
       {
       	    //验证
	       	$Md5Value = md5($order_id.$Timestamp.SCKEY);

	       	if($Encrypt == $Md5Value)
	       	{
	       		try
	       		{
	       			$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		       		//查询
		       		$select = $connection->select()
		       		->from('sales_flat_order', array('*'))->where('entity_id=?',$order_id)->group('entity_id');
		       		$rowsArray = $connection->fetchAll($select);
		       		$rowArray =$connection->fetchRow($select);

		       		if($rowArray == "[]")
		       		{
		       			$returnValue = OrderState::No;
		       		}
			   }
		       catch (Exception $e)
	       	   {
	       	   	 $returnValue = OrderState::No;
	       	  	 print $e;
	       	  	 exit();
	       	   }
	       	}
	       	else
	       	{
	       		$ReValue=OrderAddState::PARAMER_ERROR;
	       		print "数据验证不通过！";
	       		exit();
	       	}
       	}
       	else
       	{
       		$ReValue=OrderAddState::TIME_OUT;
       		echo time().'时间戳超时！';
       		exit();
       	}

       	return $returnValue;
    }

    /**
     Summary ：添加订单.
     Author  ：Henry.
     Add Time：2014-09-05.
     **/
    public function Addorder1Action()
    {

    	$Token =	$_POST['p1'];
    	$Customer_Id =	$_POST['p1a'];//18
    	$ProductXML  =	$_POST['p2'];
    	$Timestamp   =	$_POST['p3'];//1410471939
    	$Encrypt     =	$_POST['p4'];//'78e40028e2edf3c5d78d3f45c701cf2d';
    	$plist =	$this->ParseProductXML($ProductXML);
    	$OrderId = date('YmdHis',time());
    	$OrderId=substr($OrderId,2);
    	$ReValue = OrderAddState::SUCCESSFUL;

    	if($Customer_Id =='')
    	{
    		return OrderAddState::PARAMER_ERROR;
    	}

    	//如果在时间戳范围内则进行验证及其订单入库操作.
    	if(($Timestamp + TIMESTEMP) > time())
    	{
    		//验证
    		$Md5Value = md5($Token.$Customer_Id.$Timestamp.SCKEY);

    		if($Encrypt == $Md5Value)
    		{
    			try
    			{
    				$tableName = 'sales_flat_order';
    				$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    				$connection->beginTransaction();
    				$fields = array();

    				//添加订单信息.
    				$fields['entity_id']= $OrderId;
    				$fields['total_item_count']= 1;
    				$fields['state']=OrderState::WAIT_PAYMENT;
    				$fields['status']="pending_payment";
    				$fields['customer_id']=$Customer_Id;
    				$fields['subtotal']=109;
    				$fields['created_at']=date('Y-m-d H:i:s',time());

    				// 		       		$fields['customer_email']=$Customer_email;
    				// 		       		$fields['customer_lastname']=$Customer_lastname;
    				// 		       		$fields['customer_firstname']=$Customer_firstname;
    				// 		       		$fields['billing_address_id']=$billing_address_id;
    				// 		       		$fields['customer_group_id']=$customer_group_id;

    				$fields['store_id']= Mage::app()->getStore()->getStoreId();
    				$fields['shipping_description']='免运费';
    				$fields['base_shipping_amount']='0';

    				$fields['store_name']= Mage::app()->getStore()->getName();
    				$fields['remote_ip']=$_SERVER['REMOTE_ADDR'];
    				$fields['shipping_method']='freeshipping_freeshipping';
    				$fields['store_currency_code']=Mage::app()->getStore()->getCurrentCurrencyCode();

    				$connection->insert($tableName, $fields);
    				$connection->commit();
    				// 		       		print 'add new order success!';exit();
    				$addproductValue = $this->addorderproduct($OrderId,$plist,$connection);

    				if($addproductValue==1)
    				{
    					$ReValue = $OrderId;
    					$Barcode=$plist[0]->barcode.','.$plist[1]->barcode;
    					$p3=0;
    					$Timestamp=time();
    					$Md5Value = Md5($Token.$OrderId.$p3.$Barcode.$Timestamp.SCKEY);
    					$postAddress='https://sc/api/update_tx.aspx';
    					$postParameter =
    					'p1='.$Token.
    					'&p2='.$OrderId.
    					'&p3='.$p3.
    					'&p4='.$Barcode.
    					'&p6='.$Timestamp.
    					'&p7='.$Md5Value;

    					$reMsg = $this->request_by_curl($postAddress,$postParameter);

    				}
    				header("Content-Type: text/html; charset=gb2312");
    				$User =	$this->GetUserInfo($Customer_Id);

    				if($User->toJson() == "[]")
    				{
    					print "用户为空 跳转到添加地址配送界面 需要客户手动输入";

    				}
    				else
    				{
    					print "查到用户数据 用户信息显示到地址配送页面".'Order Id'.$OrderId;
    					$this->_redirectUrl('getorderinfo/id/'.$OrderId);
    				}
    			}
    			catch (Exception $e)
    			{
    				print $e;
    			}
    		}
    		else
    		{
    			$ReValue=OrderAddState::PARAMER_ERROR;
    			print "数据验证不通过！";
    		}
    	}
    	else
    	{
    		$ReValue=OrderAddState::TIME_OUT;
    		echo time().'时间戳超时！';
    		exit();
    	}

    	return $ReValue;
    }

    /**
     Summary ：添加订单.
     Author  ：Henry.
     Add Time：2014-09-05.
     **/
    public function AddorderAction()
    {
    	$Token =	$_POST['p1'];
//     	$Customer_Id =	$_POST['p1a'];
     	$ProductXML  =	$_POST['p2'];
//     	$Timestamp   =	$_POST['p3'];
//     	$Encrypt     =	$_POST['p4'];
    	$Mobile = $_POST['p5'].$_POST['p6'];
    	$Email = $_POST['p7'].'@'.$_POST['p8'];

    	$Customer_Id =	18;
    	$Timestamp   =	time();
    	$Encrypt     =	md5($Token.$Customer_Id.$Timestamp.SCKEY);

    	$plist = $this->ParseProductXML($ProductXML);
    	if(count($plist)==0)
    	{
    		print '输入参数有误，请检查XML是否合法！'.$ProductXML;
    		exit();
    	}
    	$ReValue = OrderAddState::SUCCESSFUL;

    	if($Customer_Id =='')
    	{
    		return OrderAddState::PARAMER_ERROR;
    	}

    	//如果在时间戳范围内则进行验证及其订单入库操作.
    	if(($Timestamp + TIMESTEMP) > time())
    	{
    		//验证
    		$Md5Value = md5($Token.$Customer_Id.$Timestamp.SCKEY);

    		if($Encrypt == $Md5Value)
    		{
    			try
    			{
    				$OrderId = $this->AddOrder($Customer_Id, $plist);

    				if($OrderId != 0)
    				{
    					print '添加成功OrderId='.$OrderId;

    					$Barcode=$plist[0]->barcode.','.$plist[1]->barcode;
    					$p3=0;
    					$Timestamp=time();
    					$Md5Value = Md5($Token.$OrderId.$p3.$Barcode.$Timestamp.SCKEY);
    					$postAddress='https://sc/api/update_tx.aspx';
    					$postParameter =
    					'p1='.$Token.
    					'&p2='.$OrderId.
    					'&p3='.$p3.
    					'&p4='.$Barcode.
    					'&p6='.$Timestamp.
    					'&p7='.$Md5Value;

    					$reMsg = $this->request_by_curl($postAddress,$postParameter);
    					$Msg='订单号:'.$OrderId.' [杜蕾斯商城]';
    					//$this->SendSMS($Mobile,$Msg);
    					//$this->_redirectUrl('view/order_id/'.$OrderId);
    					$this->_redirectUrl('reorder/order_id/'.$OrderId);
    				}
    			}
    			catch (Exception $e)
    			{
    				print $e;
    			}
    		}
    		else
    		{
    			$ReValue=OrderAddState::PARAMER_ERROR;
    			print "数据验证不通过！";
    		}
    	}
    	else
    	{
    		$ReValue=OrderAddState::TIME_OUT;
    		echo time().'时间戳超时！';
    		exit();
    	}

    	return $ReValue;
    }

    /**
    Summary ：添加订单方法$user_id:用户ID $Prudcts:产品集合.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function AddOrder($user_id,$Prudcts)
    {
    	$reValue=false;
    	try
    	{
	    	//初始化程序，设置当前店铺
		    $store = Mage::app()->getStore();
		    //通过电子邮件获取用户，当然也可以不获取，创建guest订单
		    $customer = Mage::getModel('customer/customer');
		    $customer->setStore($store);
		    $customer->load($user_id);   //初始化Quote，Magento的订单是通过Quote来转化过去的
		    $quote = Mage::getModel('sales/quote');
		    $quote->setStore($store);
		    $quote->assignCustomer($customer);//如果有用户则执行这个

		    foreach ($Prudcts as $p)
		    {
		    	$id = Mage::getModel('catalog/product')->getIdBySku($p->sku);

		    	//添加商品到Quote
		    	$quote->addProduct(Mage::getModel('catalog/product')->load($id), new Varien_Object(array('qty' => 1)));

		    }

		    //设置账单和收货品地址
		    $billingAddress = $quote->getBillingAddress()->addData($customer->getPrimaryBillingAddress());
		    $shippingAddress = $quote->getShippingAddress()->addData($customer->getPrimaryShippingAddress());

		    //设置配送和支付方式
 		    $shippingAddress->setCollectShippingRates(true)->collectShippingRates() ->setShippingMethod('freeshipping_freeshipping')->setPaymentMethod('alipay_payment');
 		    $quote->getPayment()->importData(array('method' => 'alipay_payment'));

		    //Quote计算运费
		    $quote->collectTotals()->save();

		    //将Quote转化为订单
		    $service = Mage::getModel('sales/service_quote', $quote);

		    $service->submitAll();

		    $order = $service->getOrder();

		    /***至此订单已经成功生成，下面是注册付款信息***/
		    $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();
		    $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::REPORT_DATE_TYPE_ORDER_CREATED);
		    $invoice->register();
		    $transaction = Mage::getModel('core/resource_transaction') ->addObject($invoice) ->addObject($invoice->getOrder());
		    $transaction->save();

		    $order_id = $order->getData('entity_id');

		    $reValue = $this->UpdateOrderProduct($user_id,$order_id, $Prudcts);
		    //$this->addComment($order_id,'Pending Payment','this test order by hery',false);
		}
    	catch (Exception $ex)
    	{
    		throw $ex;
    	}
		return $reValue;
    }
    //修改订单状态
    public function addComment($orderIncrementId, $status, $comment = null, $notify = false)
    {  print $orderIncrementId;
        $order = $this->_initOrder($orderIncrementId);
        print count($order);
        $order->addStatusToHistory($status, $comment, $notify);
        print $order->toJson();
        try {
            if ($notify && $comment) {
                $oldStore = Mage::getDesign()->getStore();
                $oldArea = Mage::getDesign()->getArea();
                Mage::getDesign()->setStore($order->getStoreId());
                Mage::getDesign()->setArea('frontend');
            }
            $order->save();
            $order->sendOrderUpdateEmail($notify, $comment);
            if ($notify && $comment) {
                Mage::getDesign()->setStore($oldStore);
                Mage::getDesign()->setArea($oldArea);
            }
        } catch (Mage_Core_Exception $e) {
            $this->_fault('status_not_changed', $e->getMessage());
        }
        return true;
    }

    /**
     Summary ：修改订单产品.
     Author  ：Henry.
     Add Time：2014-09-05.
     **/
    public function UpdateOrderProduct($User_id,$OrderId,$PMList)
    {
    	$tableName = 'sales_flat_order_item';
    	$length = count($PMList);

    	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$connection->beginTransaction();

    	$reValue=$OrderId;

    	//获取用户
    	try
    	{
	    	for ($i=0; $i< $length; $i++)
	    	{
	    		$fields = array();

	    		//更新
	    		$fields['type'] = $PMList[$i]->type;
	    		$fields['updated_at'] = date('Y-m-d H:i:s',time());

	    		if($PMList[$i]->type != 'AB')
	    		{
	    			$fields['bg_type'] = $PMList[$i]->bg_type;
	    			$fields['bg_option'] = $PMList[$i]->bg_option;
	    			$fields['zs'] = $PMList[$i]->zs;
	    			$fields['text'] = $PMList[$i]->text;
	    			$fields['qrcode'] = $PMList[$i]->qrcode;
	    			$fields['barcode'] = $PMList[$i]->barcode;
	    			$fields['qty_ordered'] = 1;

	    		}
	    		else
	    		{
	    			$fields['bg_type'] = $PMList[$i]->bg_type1.';'.$PMList[$i]->bg_type2;
	    			$fields['bg_option'] = $PMList[$i]->bg_option1.';'.$PMList[$i]->bg_option2;
	    			$fields['zs'] = $PMList[$i]->zs1.';'.$PMList[$i]->zs2;
	    			$fields['text'] = $PMList[$i]->text1.';'.$PMList[$i]->text2;
	    			$fields['qrcode'] = $PMList[$i]->qrcode1.';'.$PMList[$i]->qrcode2;
	    			$fields['barcode'] = $PMList[$i]->barcode1.';'.$PMList[$i]->barcode2;
	    			//$fields['qty_ordered'] = 2;
	    			//$fields['price'] = 218;
	    		}
	    		$where = $connection->quoteInto('order_id = '.$OrderId.' and sku = '.$PMList[$i]->sku);
	    		$connection->update($tableName, $fields, $where);
	    		$connection->commit();
	    	}
    	}
    	catch (Exception $e)
    	{
    		$reValue=false;
    		print $e;
    	}
    	return $reValue;
    }

    /**
     * Curl版本
     * 使用方法：
     * $post_string = "app=request&version=beta";
     * request_by_curl('http://facebook.cn/restServer.php',$post_string);
     */
    function request_by_curl($remote_server, $post_string)
    {

    	print 'begin into it s init';
    	$ch = curl_init();
    	print 'begin into it';
    	curl_setopt($ch, CURLOPT_URL, $remote_server);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, 'mypost=' . $post_string);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");
    	print 'begin into curl_exec()';
    	$data = curl_exec($ch);
    	print 'begin into curl_exec() end';
    	curl_close($ch);
    	print 'begin into curl_close() end';

    	print $data;
    	return $data;
    }

    /**
    Summary ：获取用户信息.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function GetUserAction()
    {
    	$User = array();
    	header("Content-Type: text/html; charset=gb2312");
    	$UserId = $_POST['UserId'];
    	$User[0] = $this->GetUserInfo($UserId);

     	$BillId = $User->getData("default_billing");
     	$ShippingId = $User->getData("default_shipping");

     	$User[1] = $this->GetUserBillingAddress($BillId);
     	$User[2] = $this->GetUserShppingAddress($ShippingId);

     	return $User;
    }

    /**
    Summary ：保存用户信息.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function SaveUserAction()
    {
    	$UserId = $_POST['UserId'];
    	$email = $_POST['email'];
    	$is_active = $_POST['is_active'];
    	$created_in = $_POST['created_in'];
    	$firstname = $_POST['firstname'];
    	$lastname = $_POST['lastname'];
    	$password = $_POST['password'];

    	$User = $this->GetUserInfo(000);
    	if($User->toJson() != "[]")
    	{
    		$User->setData('updated_at',date("Y-m-d H:i:s"));

	    	if($email != "")
	    	{
	    		$User->setData('email',$email);
	    	}
	    	if($is_active != "")
	    	{
	    		$User->setData('is_active',$is_active);
	    	}
	    	if($created_in != "")
	    	{
	    		$User->setData('created_in',$created_in);
	    	}
	    	if($firstname != "")
	    	{
	    		$User->setData('firstname',$firstname);
	    	}
	    	if($lastname != "")
	    	{
	    		$User->setData('lastname',$lastname);
	    	}
	    	if($password != "")
	    	{
	    		$User->setData('password_hash',md5($password));
	    	}

	    	//entity_type_id
	    	//website_id
	    	$User->save();
    	}
    }
    /**
    Summary ：保存用户绑定地址.
    Author  ：Henry.
    Add Time：2014-09-06.
    **/
    public function SaveBillingAddressAction()
    {
    	//用户ID.
    	$id = $_POST['id'];
    	if($id != "")
    	{
	    	$addressId = $this->GetUserInfo($id)->getData("default_billing");

	    	$is_active = $_POST['is_active'];
	    	$firstname = $_POST['firstname'];
	    	$lastname = $_POST['lastname'];
	    	$city = $_POST['city'];
	    	$country_id = $_POST['country_id'];
	    	$region = $_POST['region'];
	    	$postcode = $_POST['postcode'];
	    	$telephone = $_POST['telephone'];
	    	$fax = $_POST['fax'];
	    	$street = $_POST['street'];
	    	if($addressId != "")
	    	{
		    	$User = $this->GetUserBillingAddress($addressId);
		    	$User->setData('updated_at',date("Y-m-d H:i:s"));
		    	if($is_active != "")
		    	{
		    		$User->setData('is_active',$is_active);
		    	}
		    	if($firstname != "")
		    	{
		    		$User->setData('firstname',$firstname);
		    	}
		    	if($lastname != "")
		    	{
		    		$User->setData('lastname',$lastname);
		    	}
		    	if($city != "")
		    	{
		    		$User->setData('city',$city);
		    	}
		    	if($country_id != "")
		    	{
		    		$User->setData('country_id',$country_id);
		    	}
		    	if($region != "")
		    	{
		    		$User->setData('region',$region);
		    	}
		    	if($fax != "")
		    	{
		    		$User->setData('fax',$fax);
		    	}
		    	if($street != "")
		    	{
		    		$User->setData('street',$street);
		    	}
		    	$User->save();
	    	}
    	}
    }
    /**
    Summary ：保存用户邮寄地址.
    Author  ：Henry.
    Add Time：2014-09-06.
    **/
    public function SaveShippingAddress()
    {
        //用户ID.
    	$id = $_POST['id'];
    	if($id != "")
    	{
	    	$addressId = $this->GetUserInfo($id)->getData("default_shipping");

	    	$is_active = $_POST['is_active'];
	    	$firstname = $_POST['firstname'];
	    	$lastname = $_POST['lastname'];
	    	$city = $_POST['city'];
	    	$country_id = $_POST['country_id'];
	    	$region = $_POST['region'];
	    	$postcode = $_POST['postcode'];
	    	$telephone = $_POST['telephone'];
	    	$fax = $_POST['fax'];
	    	$street = $_POST['street'];
	    	if($addressId != "")
	    	{
		    	$User = $this->GetUserBillingAddress($addressId);
		    	$User->setData('updated_at',date("Y-m-d H:i:s"));
		    	if($is_active != "")
		    	{
		    		$User->setData('is_active',$is_active);
		    	}
		    	if($firstname != "")
		    	{
		    		$User->setData('firstname',$firstname);
		    	}
		    	if($lastname != "")
		    	{
		    		$User->setData('lastname',$lastname);
		    	}
		    	if($city != "")
		    	{
		    		$User->setData('city',$city);
		    	}
		    	if($country_id != "")
		    	{
		    		$User->setData('country_id',$country_id);
		    	}
		    	if($region != "")
		    	{
		    		$User->setData('region',$region);
		    	}
		    	if($fax != "")
		    	{
		    		$User->setData('fax',$fax);
		    	}
		    	if($street != "")
		    	{
		    		$User->setData('street',$street);
		    	}
		    	$User->save();
	    	}
    	}
    }

    /**
    Summary ：由用户ID获取用户信息.
    Author  ：Henry.
    Add Time：2014-09-06.
    **/
    public function GetUserInfo($userId)
    {
    	 $User = Mage::getModel('customer/customer')->load($userId);

    	 return $User;
    }

    /**
    Summary ：获取用户绑定地址.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function GetUserBillingAddress($id)
    {
    	$User = Mage::getModel('customer/session')->getCustomer()->getAddressById($id);
    	return $User;
    }
    /**
    Summary ：获取用户邮寄地址.
    Author  ：Henry.
    Add Time：2014-09-05.
     */
    public function GetUserShppingAddress($id)
    {
    	$User = Mage::getModel('customer/session')->getCustomer()->getAddressById($id);
    	return $User;
    }



    public function myorderAction()
    {
//     	print date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);;
//     	exit();

    	$this->_loadValidMyOrder();

        $this->loadLayout();
//         $this->_initLayoutMessages('catalog/session');

        //$navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');
//         if ($navigationBlock) {
//             $navigationBlock->setActive('sales/order/myorder');
//         }
        $this->renderLayout();
    }

    /**
    Summary ：获取订单信息.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function getorderinfoAction()
    {   //sales_flat_order
    	$orderId = $this->getRequest()->getParam('id');
    	print 'GetOrderInfoAction(orderid='.$orderId.')';

    	print $orderId;
    	//exit();
    	//$this->_redirectUrl('../../view/order_id/'.$orderId);

//     	exit();
//     	$orderId = $_POST['orderId'];
     	$this->getorderbyid($orderId);



    	//$this->_redirectUrl('GetOrderList');
    }

    public function getorderbyid($orderId,$connection=null)
    {
    	if($connection == null)
    	 $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	//查询
    	$select = $connection->select()
    	->from('sales_flat_order', array('*'))->where('entity_id=?',$orderId)->group('entity_id');
    	$rowsArray = $connection->fetchAll($select);
    	$rowArray =$connection->fetchRow($select);

    	$orderInfo = $rowArray;//$rowArray['entity_id'];

    	return $orderInfo;
    }

    /**
    Summary ：获取订单列表.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function GetOrderListAction()
    {
    	$CustomerId = $_POST['customer_id'];
    	$orderList = Mage::getModel('sales/order')->getCollection();
    	$order = Array();
    	$index =0;
    	foreach($orderList as $att)
    	{

    		if($att->getData("customer_id") == $CustomerId)
    		{
    			$order[$index] = $att;
    			$index++;
    		}
    	}
    	return $order;
    }

    /**
    Summary ：设置订单状态.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function SetOrderStatusAction()
    {



//     	$aProjectKey =	$_POST['aProjectKey'];
//     	$aUserKey =	$_POST['aUserKey'];

    	$orderId =	$_POST['OrderId'];
    	$PrintId =	$_POST['PrintId'];
    	$orderState =	$_POST['Status'];
    	$Timestamp = $_POST['Timestamp'];
    	$Encrypt =	$_POST['Encrypt'];

    	$ReValue=OrderAddState::SUCCESSFUL;

    	print 'Gary data of timestamp is '.$Timestamp;
    	$orderInfo =$this->GetOrderInfo($orderId);

    	if($orderInfo->toJson() == "[]")
    	{
    		print "不存在此订单！";
    		exit();
    	}
    	else
    	{
    		//print "查到订单数据";
    		//如果在时间戳范围内则进行验证及其订单入库操作.
    		if($Timestamp+TIMESTEMP > time())
    		{
    			//验证
    			$Md5Value = md5($orderId.$PrintId.$orderState.Timestamp.PCKEY);

    			if($Encrypt == $Md5Value)
    			{
    				try
    				{
    					foreach($orderInfo as $att)
    					{
    						$att->setData('status',$orderState);
    						$att->save();
    					}
    				}
    				catch (Exception $ex) { $ReValue = OrderAddState::SERVER_ERROR; }
    			}
    		}
    		else
    		{
    			$ReValue=OrderAddState::TIME_OUT;
    		}
    	}

    	return $ReValue;
    }

    /**
     Summary ：发送短信.
     Author  ：Henry.
     Add Time：2014-09-05.
     **/
    public function SendSMS($mobile,$content)
    {
    	$reValue=true;
    	if($mobile !='')
    	{
    		$username = "SDK2101";
    		$password = "123456";
    		$content = rawurlencode($content);
    		$gateway = "http://api.bjszrk.com/sdk/BatchSend.aspx?CorpID={$username}&Pwd={$password}&Mobile={$mobile}&Content={$content}&Cell=&SendTime=";
    		if (0 > file_get_contents($gateway))
    		{
    			$reValue=false;
    		}
    	}
    	else
    	{
    		print '发送手机号不能为空！';
    		exit();
    	}
    	return $reValue;
    }

    /**
    Summary ：发送短信.
    Author  ：Henry.
    Add Time：2014-09-05.
    **/
    public function SendSMSAction()
    {
//     	$content=$_POST['text'];
//     	$mobile =$_POST['phnum'];
    	    header("Content-Type: text/html; charset=utf-8");
	        //短信接口用户名 $uid
	        $uid = 'SDK2101';
	        //短信接口密码 $passwd
	        $passwd = '123456';
	        //发送到的目标手机号码 $telphone
	        $telphone = '18211062453';
	        //短信内容 $message
	        $message = "测试信息 验证码为 123232e [杜蕾斯验证码]";
	        //$message = iconv("utf-8","gb2312//IGNORE",$message);
	        $message =rawurlencode($message);

	        $gateway = "http://api.bjszrk.com/sdk/BatchSend.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$telphone}&Content={$message}&Cell=&SendTime=&encode=gb2312";
	        $reValue=true;
	        if($telphone !='')
	        {
	        	$result = file_get_contents($gateway);

	        	if(0 <$result)
	        	{
	        		echo "发送成功! 发送时间".date("Y-m-d H:i:s");
	        	}
	        	else
	        	{
	        		echo "发送失败, 错误提示代码: ".$result;
	        	}
	        }
	        else
	        {
	        	print '发送手机号不能为空！';
	        	exit();
	        }
	        print $reValue;
	        return $reValue;
    }

    /**
     Summary ：获取订单数据并返回XML字符串.
     Author  ：Henry.
     Add Time：2014-09-19.
     **/
    public function GetOrderToXMLStr($OrderId,$Status)
    {
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
    	$connection->beginTransaction();

    	$select = $connection->select()
    	->from('sales_flat_order_item', array('*'))->where('order_id=?',$OrderId);
    	$rowsArray = $connection->fetchAll($select);
    	$productDeital="<order>
    				<id>".$OrderId."</id>
    				<orderStateId>".$Status."</orderStateId><products>";

    	 foreach ($rowsArray as $p)
    	 {
    	 	$bg_types = explode(";",$p['bg_type']);
    	 	$bg_options = explode(";",$p['bg_option']);
    	 	$barcodes = explode(";",$p['barcode']);
    	 	$zss = explode(";",$p['zs']);

    	 	$texts = explode(";",$p['text']);

    	 	$Length = count($bg_types);

    	 	//print $Length.'<br/>';
    	 	for ($i=0;$i<$Length;$i++)
    	 	{
    	 		$productDeital +="<product>
	    				    		<sku>".$p['sku']."</sku>
						    		<barcode>".$barcodes[$i]."</barcode>
						    		<qrcode>".$p['qrcode']."</qrcode>
	    				    		<quantity>1</quantity>
	    			                <type>".$p['type']."</type>
	    							<bg_type>".$bg_types[$i]."</bg_type>
	    				    		<bg_option>".$bg_options[$i]."</bg_option>
	    			                <zs1>".$zss[$i]."</zs1>
	    			                <zs2></zs2>
	    			                <text>".$texts[$i]."</text>
	    			             </product>";
    	 	}
    	 }

    	 $productDeital +=" </products> </order>";

    	 return $productDeital;
    }

     /**
     Summary ：打印接口调用.
     Author  ：Henry.
     Add Time：2014-09-19.
     **/
    public function PrintOrderAction()
    {
    	//     	$pp = new product();
		//     	$pp->sku ='111';

//     	$this->GetOrderToXMLStr(32);
//     	exit();
    	$postAddress='http://smart.sharp-iris.com/SmartflowRB/SmartflowWCF.svc?wsdl';
    	$productDeital="
    			<order>
    				<id>32</id>
    				<orderStateId>2000</orderStateId>
    			    <products>
    	    					<product>
    				    			<sku>101</sku>
					    			<barcode>121111111111111111</barcode>
					    			<qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
    				    			<quantity>1</quantity>
    			                    <type>AA</type>
    								<bg_type>1</bg_type>
    				    			<bg_option>1</bg_option>
    			                    <zs1>2</zs1>
    			                    <zs2>1</zs2>
    			                    <text>Hi Henry...</text>
    			                </product>
    			    </products>
    			    </order>";

    	$wcfClient = new SoapClient($postAddress);


    	 $product = new product();
    	 $product ->sku ='101';
    	 $product ->barcode ='000000001';
    	 $product ->qrcode ='111';
    	 $product ->quantity ='1';
    	 $product ->type ='AA';
    	 $product ->bg_type ='1';
    	 $product ->bg_option ='1';
    	 $product ->zs1 ='2';
    	 $product ->zs2 ='1';
    	 $product ->text ='Hi Henry...';

    	 $product1 = new product();
    	 $product1 ->sku ='102';
    	 $product1 ->barcode ='000000001';
    	 $product1 ->qrcode ='111';
    	 $product1 ->quantity ='1';
    	 $product1 ->type ='AA';
    	 $product1 ->bg_type ='1';
    	 $product1 ->bg_option ='1';
    	 $product1 ->zs1 ='2';
    	 $product1 ->zs2 ='1';
    	 $product1 ->text ='Hi Henry...';

    	 $order = new order();
    	 $order-> id ='DUX00000000';
    	 $order->orderStateId =2000;
    	 $order-> products = array($product,$product1);

    	 $pp = $wcfClient->AddRBOrder(array(
    	 		'projectGuid' => '3e618ae6‐351e‐e411‐8444‐00155d282801',
    	 		'userGuid' => '5853b03d‐ed22‐e411‐8d9d‐00155d282801',
    	 		'order' => $order
    	 ));

     	 print $pp;
    }

    /**
     * Check osCommerce order view availability
     *
     * @deprecate after 1.6.0.0
     * @param   array $order
     * @return  bool
     */
    protected function _canViewOscommerceOrder($order)
    {
        return false;
    }

    /**
     * osCommerce Order view page
     *
     * @deprecate after 1.6.0.0
     *
     */
    public function viewOldAction()
    {
        $this->_forward('noRoute');
        return;
    }
}
class PPP
{

  public $YourName ;
}
class OrderEnum
{
	const FAILURE = 0;
	const SUCCESSFUL=1;
}

class OrderAddState extends OrderEnum {
	const PARAMER_ERROR = -1;
	const SERVER_ERROR = 500;
	const TIME_OUT = -2;
}
class OrderState extends OrderEnum {
	const WAIT_PAYMENT = '等待付款';
	const COMPLETE = '完成';
	const CLOSE = '关闭';
	const CANCEL = '取消';
	const HOLD_ON = '挂起';
	const No = 0;
	const Yes = 1;
}
/**
 * @Summary :地址类型.
 * @author  :Henry.
 * @Add time:2014-09-05.
 */
class Enum_AddressType
{
	const Billing = 0;
	const Shipping =1;
}
/**
 * @Summary :产品数据实体.
 * @author  :Henry.
 * @Add time:2014-09-05.
 */
class ProductModel
{
	function __construct(){
		//echo 'A new product data model have created.'.date("Y-m-d H:i:s");
	}
	public $sku,$type,$name,$zs,$zs1,$zs2,$bg_type,$bg_option,$text,$qrcode,$bg_type1,$bg_type2,$bg_option1,$bg_option2,$text1,$text2,$qrcode1,$qrcode2
	,$barcode,$barcode1,$barcode2,$price,$price1,$price2,$entity_id,$entity_id1,$entity_id2;
}




class order
{
	function __construct(){
		//echo 'A new product data model have created.'.date("Y-m-d H:i:s");
	}
	public $id ,$orderStateId,$products= array();
}

class product
{

	public $sku,$barcode,$qrcode,$quantity,$type,$bg_type,$bg_option,$zs1,$zs2,$text;


}













