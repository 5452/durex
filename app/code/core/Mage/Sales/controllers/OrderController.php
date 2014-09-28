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
define("BCKEY",'A5fqWe989faD6s5d4fIas65d4@fa6sd8f7a');
define("SCKEY",'djsc123');

class Mage_Sales_OrderController extends Mage_Sales_Controller_Abstract
{

	public function indexAction()
	{
		$_SOAP = new SoapClient('http://124.205.25.148/m/index.php/api/soap/?wsdl');
		$sessionId = $_SOAP->login('Henry', '000000');
		return  var_export('111');
// 		$orderList = $_SOAP->call($sessionId, 'sales_order.list',array(array('created_at'=>array
// 				('from'=>$formTime,'to'=>$toTime2))) );
// 		foreach($orderList as $order){
// 			echo var_export($order);
// 			break;
// 		}
// 		$filters = array(
// 				'sku' => array('like'=>'%t%')
// 		);

// 		$products = $proxy->call($sessionId, 'product.list', array($filters));

// 		var_dump($products);

		$_SOAP->endSession($sessionId);

	    return $sessionId;
	}
	public function webServerAPI()
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

    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     */
    public function preDispatch()
    {
    	Mage::getSingleton("customer/session")->loginById(18);
         parent::preDispatch();
//          $action = $this->getRequest()->getActionName();
//         $loginUrl = Mage::helper('customer')->getLoginUrl();
      
//         if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
//             $this->setFlag('', self::FLAG_NO_DISPATCH, true);
//         }
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
    Summary ���锟界��锝�锟斤拷娴���锟斤拷XML.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
			    			<name>ns)</name>
			    			<zs>2</zs>
			    			<bg_type>1</bg_type>
			    			<bg_option>1</bg_option>
			    			<text>Hi...</text>
			    			<barcode></barcode>
			    			<qrcode>http://pppcs.durex.com.cn/api/app?p1=....</qrcode>
		    			</product>
		    			
    			</order>";

    	$Order = simplexml_load_string($productDetail);

    	foreach($Order as $product)   //锟斤拷宄帮拷锟�XML��电�����锟斤拷锟斤拷锟姐��锟斤拷濮ｏ拷娑�锟芥��锟界��锟斤拷锟斤拷锟斤拷��革拷锟芥��锟斤拷锟斤拷娑�锟芥��锟界猾璁虫��娴�锟斤拷锟芥��锟斤拷锟斤拷锟界�电�����
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

// 		    	$time =time();
// 		    	$code=date('Y',$time);
// 		    	$code=substr($code,2);
// 		    	$code +=date('m',$time);
// 		    	$codeM = $code;

// 		    	$PM->barcode='103601'.($codeM.date('dHis',$time));
// 		    	$PM->barcode1='103601'.(($codeM+12).date('dHis',$time));
// 		    	$PM->barcode2='103601'.(($codeM+13).date('dHis',$time));
		    	array_push($prductList,$PM);
        	}
        }

        return $prductList;
    }

    /**
     Summary ���锟界��锝�锟斤拷娴���锟斤拷XML.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-05.
     **/
    public function ParseProductXML($productDetail)
    {
    	header("Content-Type: text/html; charset=utf-8");
    	$prductList = array();

    	 
    	$Order = simplexml_load_string($productDetail);

    	foreach($Order as $product)  
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

    			array_push($prductList,$PM);
    		}
    	}

    	return $prductList;
    }

    /**
    Summary ���锟藉ǎ璇诧拷锟界�����锟斤拷娴���锟斤拷.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
		    	//濞ｈ�诧拷锟界�����锟斤拷娣����锟斤拷.
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
    Summary ���锟藉Λ锟斤拷锟姐��锟姐��锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
    **/
    public function isorderAction()
    {
    	$order_id  =	$_POST['p1'];
        $Timestamp =    $_POST['p2'];
        $Encrypt   =	$_POST['p3'];

        $returnValue = OrderState::Yes;


       //婵★拷锟斤拷锟斤拷锟姐��锟藉��锟藉��锟藉��锟斤拷锟斤拷���锟斤拷锟斤拷锟芥�╋拷���锟芥��锟界��锟斤拷锟斤拷锟斤拷��帮拷���锟斤拷锟斤拷��ワ拷锟斤拷锟斤拷娴ｏ拷.
       if(($Timestamp + TIMESTEMP) > time())
       {
       	    //妤�锟界��锟�
	       	$Md5Value = md5($order_id.$Timestamp.SCKEY);

	       	if($Encrypt == $Md5Value)
	       	{
	       		try
	       		{
	       			$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		       		//锟斤拷���锟斤拷
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
	       		print "锟斤拷���锟斤拷妤�锟界��锟芥��锟斤拷锟斤拷��╋拷���锟�";
	       		exit();
	       	}
       	}
       	else
       	{
       		$ReValue=OrderAddState::TIME_OUT;
       		echo time().'锟斤拷���锟藉��锟藉��锟斤拷锟斤拷璁癸拷锟�';
       		exit();
       	}

       	return $returnValue;
    }

    /**
     Summary ���锟藉ǎ璇诧拷锟界�����锟斤拷.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-05.
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

    	//婵★拷锟斤拷锟斤拷锟姐��锟藉��锟藉��锟藉��锟斤拷锟斤拷���锟斤拷锟斤拷锟芥�╋拷���锟芥��锟界��锟斤拷锟斤拷锟斤拷��帮拷���锟斤拷锟斤拷��ワ拷锟斤拷锟斤拷娴ｏ拷.
    	if(($Timestamp + TIMESTEMP) > time())
    	{
    		//妤�锟界��锟�
    		$Md5Value = md5($Token.$Customer_Id.$Timestamp.SCKEY);

    		if($Encrypt == $Md5Value)
    		{
    			try
    			{
    				$tableName = 'sales_flat_order';
    				$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    				$connection->beginTransaction();
    				$fields = array();

    				//濞ｈ�诧拷锟界�����锟斤拷娣����锟斤拷.
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
    				$fields['shipping_description']='锟斤拷锟芥�╋拷���锟�';
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
    					print "锟斤拷���锟借��璐�缁�锟� ��哄��娴�锟斤拷������锟斤拷锟斤拷锟芥�匡拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟� 锟斤拷锟界��锟界�广�★拷���锟斤拷锟斤拷���锟斤拷锟斤拷锟�";

    				}
    				else
    				{
    					print "锟斤拷��ワ拷���锟姐��锟介��锟界��锟斤拷 锟斤拷���锟借��淇�锟斤拷锟斤拷锟藉�с��锟斤拷��匡拷��匡拷锟斤拷锟斤拷锟斤拷锟芥い��革拷锟�".'Order Id'.$OrderId;
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
    			print "锟斤拷���锟斤拷妤�锟界��锟芥��锟斤拷锟斤拷��╋拷���锟�";
    		}
    	}
    	else
    	{
    		$ReValue=OrderAddState::TIME_OUT;
    		echo time().'锟斤拷���锟藉��锟藉��锟斤拷锟斤拷璁癸拷锟�';
    		exit();
    	}

    	return $ReValue;
    }


	public function SC_UpdateAction()
	{
	$Barcode=123433333111;
	$Token=B786C058D2854CA3A35E08F241841511;
	$p3=0;
	$Timestamp=time();
	$OrderId=100000010;
	$Barcode =122111122222;
    					$Md5Value = Md5($Token.$OrderId.$p3.$Barcode.$Timestamp.SCKEY);
    					
    					$postParameter = array(
    					p1=>$Token,
    					p2=>$OrderId,
    					p3=>$p3,
    					p4=>$Barcode,
    					p6=>$Timestamp,
    					p7=>$Md5Value);

		$url = 'http://4durex.wwwins.com.cn/api/update_tx.aspx';
		
		$header = "Content-type:application/x-www-form-urlencoded;charset=utf-8";
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParameter);
		
		$response = curl_exec($ch);
		
		if(curl_errno($ch)){
		
		    print curl_error($ch);
		
		}
		
		curl_close($ch); 
		echo $response;
 	}

    /**
     Summary ���锟藉ǎ璇诧拷锟界�����锟斤拷.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-05.
     **/
    public function AddorderAction()
    {
    	
//     	print '<!###1###!>';
//     	exit();
	    $Token =	$_POST['p1'];
     	$Customer_Id =	$_POST['p1a'];
     	
     	$ProductXML  =	$_POST['p2'];
     	$Timestamp   =	$_POST['p3'];
     	$Encrypt     =	$_POST['p4'];
    	$Mobile = $_POST['p5'].$_POST['p6'];
    	$Email = $_POST['p7'].'@'.$_POST['p8'];

    	$Customer_Id =	18;
    	//$Timestamp   =	time();
    	//$Encrypt     =	md5($Token.$Customer_Id.$Timestamp.SCKEY);

    	$plist = $this->ParseProductXML($ProductXML);
    	if(count($plist)==0)
    	{
    		print 'xml参数解析失败:'.$ProductXML;
    		exit();
    	}
    	$ReValue = OrderAddState::SUCCESSFUL;

    	if($Customer_Id =='')
    	{
    		return OrderAddState::PARAMER_ERROR;
    	}
		if(($Timestamp + TIMESTEMP) > time())
    	{
    		$Md5Value = md5($Token.$Timestamp.SCKEY);
    		if($Encrypt == $Md5Value)
    		{
    			try
    			{
    				$OrderId = $this->AddOrder($Customer_Id, $plist);
					$Timestamp   =	time();
    				if($OrderId != 0)
    				{
    					$Barcode='';
    					$p3=0;
    					$Timestamp=time();
    					$Md5Value = Md5($Token.$OrderId.$p3.$Timestamp.SCKEY);
    					
    					$postParameter = array(
    					p1=>$Token,
    					p2=>$OrderId,
    					p3=>$p3,
    					p4,
    					p6=>$Timestamp,
    					p7=>$Md5Value);

		$url = 'http://4durex.wwwins.com.cn/api/update_tx.aspx';
		
		$header = "Content-type:application/x-www-form-urlencoded;charset=utf-8";
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParameter);
		
		$response = curl_exec($ch);
		
		if(curl_errno($ch)){
		
		    print curl_error($ch);
		
		}
		
		curl_close($ch); 
		//echo $response;
		 
		$this->_redirectUrl('/m/sales/order/view/order_id/'.$OrderId);
    		//$this->_redirectUrl('reorder/order_id/'.$OrderId);
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
    			//print “333333”;
    		}
    	}
    	else
    	{
    		$ReValue=OrderAddState::TIME_OUT;
    		//echo time().’4444444’;
    		//exit();
    	}

    	print '<!###'.$ReValue.'###!>';
    	exit();
    	return $ReValue;
    }

    /**
     Summary ���锟藉ǎ璇诧拷锟界�����锟斤拷.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-05.
     **/
    public function Addorder3Action()
    {
    
    	$Token =	1;//$_POST['p1'];
    	$Customer_Id =	18;//$_POST['p1a'];
    
    	$ProductXML  =	$_POST['p2'];
    	$Timestamp   = time();//$_POST['p3'];
    	$Encrypt     =	$_POST['p4'];
    	$Mobile = $_POST['p5'].$_POST['p6'];
    	$Email = $_POST['p7'].'@'.$_POST['p8'];
    
    	$Customer_Id =	18;
    	$Timestamp   =	time();
    	$Encrypt     =	md5($Token.$Timestamp.SCKEY);
    
    	$plist = $this->ParseProductXML1($ProductXML);
    	if(count($plist)==0)
    	{
    		print 'xml参数解析失败:'.$ProductXML;
    		exit();
    	}
    	$ReValue = OrderAddState::SUCCESSFUL;
    
    	if($Customer_Id =='')
    	{
    		return OrderAddState::PARAMER_ERROR;
    	}
    	if(($Timestamp + TIMESTEMP) > time())
    	{
    		$Md5Value = md5($Token.$Timestamp.SCKEY);
    		if($Encrypt == $Md5Value)
    		{
    			try
    			{
    				$OrderId = $this->AddOrder($Customer_Id, $plist);
    				$Timestamp   =	time();
    				if($OrderId != 0)
    				{
    					$Barcode='';
    					$p3=0;
    					$Timestamp=time();
    					$Md5Value = Md5($Token.$OrderId.$p3.$Timestamp.SCKEY);
    						
    					$postParameter = array(
    							p1=>$Token,
    							p2=>$OrderId,
    							p3=>$p3,
    							p4,
    							p6=>$Timestamp,
    							p7=>$Md5Value);
    
    					$url = 'http://4durex.wwwins.com.cn/api/update_tx.aspx';
    
    					$header = "Content-type:application/x-www-form-urlencoded;charset=utf-8";
    					$ch = curl_init();
    					curl_setopt($ch, CURLOPT_URL, $url);
    					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    					curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    					curl_setopt($ch, CURLOPT_POST, true);
    					curl_setopt($ch, CURLOPT_POSTFIELDS, $postParameter);
    
    					$response = curl_exec($ch);
    
    					if(curl_errno($ch))
    					{
    
    		    			print curl_error($ch);
    
    					}
    
    					curl_close($ch);
    					//echo $response;
    						
    					$this->_redirectUrl('/m/sales/order/view/order_id/'.$OrderId);
    					//$this->_redirectUrl('reorder/order_id/'.$OrderId);
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
    			//print “333333”;
    		}
    	}
    	else
    	{
    		$ReValue=OrderAddState::TIME_OUT;
    		//echo time().’4444444’;
    		//exit();
    	}
    
    	print '<!###'.$ReValue.'###!>';
    	exit();
    	return $ReValue;
    }
    
    /**
    Summary ���锟藉ǎ璇诧拷锟界�����锟斤拷锟斤拷瑙�锟斤拷$user_id:锟斤拷���锟斤拷ID $Prudcts:娴���锟斤拷锟斤拷锟斤拷锟斤拷.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
    **/
    public function AddOrder($user_id,$Prudcts)
    {
    	$reValue=false;
    	try
    	{
	    	   //锟斤拷锟芥慨锟斤拷锟斤拷缁�锟芥�达拷���锟界����х��瑜帮拷锟斤拷锟芥�达拷锟斤拷锟�
		    $store = Mage::app()->getStore();
		    //锟斤拷锟芥�╋拷锟斤拷���锟斤拷锟斤拷锟芥����帮拷宄帮拷锟斤拷锟姐��锟藉�わ拷锟借ぐ锟斤拷锟芥�碉拷锟斤拷锟斤拷娴���わ拷锟斤拷锟藉嘲锟斤拷���锟斤拷锟斤拷瀵わ拷guest������锟斤拷
		    $customer = Mage::getModel('customer/customer');
		    $customer->setStore($store);
		    $customer = $customer->load(18);   //$user_id锟斤拷锟芥慨锟斤拷锟斤拷Quote���锟�Magento锟斤拷锟界�����锟斤拷锟斤拷锟斤拷锟斤拷��╋拷Quote锟斤拷��ㄦ��锟斤拷锟芥�╋拷锟斤拷��わ拷锟�
		    

            $quote = Mage::getModel('sales/quote');
		    $quote->setStore($store);
		    //if ($customer->toJson()->toString != [])
		    //{
		    	$quote->assignCustomer($customer);
		   
		    //}
		    foreach ($Prudcts as $p)
		    {
		    	$id = Mage::getModel('catalog/product')->getIdBySku($p->sku);
		    	$quote->addProduct(Mage::getModel('catalog/product')->load($id), new Varien_Object(array('qty' => 1)));
		    }

		    $billingAddress = $quote->getBillingAddress()->addData($customer->getPrimaryBillingAddress());
		    $shippingAddress = $quote->getShippingAddress()->addData($customer->getPrimaryShippingAddress());

			$shippingAddress->setCollectShippingRates(true)->collectShippingRates()->setShippingMethod(“freeshipping_freeshipping”)->setPaymentMethod('alipay_payment');
			$quote->getPayment()->importData(array('method' => 'alipay_payment'));
			$quote->collectTotals()->save();
			$service = Mage::getModel('sales/service_quote', $quote);
 
		    $service->submitAll();

		    $order = $service->getOrder();
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
     Summary ���锟芥��锟斤拷锟界��锟姐��锟斤拷娴���锟斤拷.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-05.
     **/
    public function UpdateOrderProduct($User_id,$OrderId,$PMList)
    {
    	$tableName = 'sales_flat_order_item';
    	$length = count($PMList);

    	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$connection->beginTransaction();

    	$reValue=$OrderId;

    	//锟斤拷宄帮拷锟斤拷锟姐��锟斤拷
    	try
    	{
	    	for ($i=0; $i< $length; $i++)
	    	{
	    		$fields = array();

	    		//锟斤拷瀛�锟斤拷
	    		$fields['type'] = $PMList[$i]->type;
	    		$fields['updated_at'] = date('Y-m-d H:i:s',time());

	    		if($PMList[$i]->type != 'AB')
	    		{
	    			$fields['bg_type'] = $PMList[$i]->bg_type;
	    			$fields['bg_option'] = $PMList[$i]->bg_option;
	    			$fields['zs'] = $PMList[$i]->zs;
	    			$fields['text'] = $PMList[$i]->text;
	    			$fields['qrcode'] = $PMList[$i]->qrcode;
	    			$fields['barcode'] = '103601'.$OrderId.'000';
	    			$fields['qty_ordered'] = 1;

	    		}
	    		else
	    		{
	    			$fields['bg_type'] = $PMList[$i]->bg_type1.';'.$PMList[$i]->bg_type2;
	    			$fields['bg_option'] = $PMList[$i]->bg_option1.';'.$PMList[$i]->bg_option2;
	    			$fields['zs'] = $PMList[$i]->zs1.';'.$PMList[$i]->zs2;
	    			$fields['text'] = $PMList[$i]->text1.';'.$PMList[$i]->text2;
	    			$fields['qrcode'] = $PMList[$i]->qrcode1.';'.$PMList[$i]->qrcode2;
	    			$fields['barcode'] = '103601'.$OrderId.'001'.';'.'103601'.$OrderId.'002';
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
     * Curl锟斤拷锟斤拷锟斤拷
     * 娴ｈ法锟姐��锟借��锟斤拷���锟�
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
    Summary ���锟斤拷锟藉嘲锟斤拷锟斤拷���锟借��淇�锟斤拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
    Summary ���锟芥��锟界��锟斤拷锟姐��锟借��淇�锟斤拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
    Summary ���锟芥��锟界��锟斤拷锟姐��锟介��锟斤拷��癸拷锟斤拷��匡拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-06.
    **/
    public function SaveBillingAddressAction()
    {
    	//锟斤拷���锟斤拷ID.
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
    Summary ���锟芥��锟界��锟斤拷锟姐��锟界�斤拷锟界�碉拷锟斤拷��匡拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-06.
    **/
    public function SaveShippingAddress()
    {
        //锟斤拷���锟斤拷ID.
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
    Summary ���锟斤拷锟借京锟姐��锟斤拷ID锟斤拷宄帮拷锟斤拷锟姐��锟借��淇�锟斤拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-06.
    **/
    public function GetUserInfo($userId)
    {
    	 $User = Mage::getModel('customer/customer')->load($userId);

    	 return $User;
    }

    /**
    Summary ���锟斤拷锟藉嘲锟斤拷锟斤拷���锟介��锟斤拷��癸拷锟斤拷��匡拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
    **/
    public function GetUserBillingAddress($id)
    {
    	$User = Mage::getModel('customer/session')->getCustomer()->getAddressById($id);
    	return $User;
    }
    /**
    Summary ���锟斤拷锟藉嘲锟斤拷锟斤拷���锟界�斤拷锟界�碉拷锟斤拷��匡拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
    Summary ���锟斤拷锟藉嘲锟斤拷������锟斤拷娣����锟斤拷.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
    	//锟斤拷���锟斤拷
    	$select = $connection->select()
    	->from('sales_flat_order', array('*'))->where('entity_id=?',$orderId)->group('entity_id');
    	$rowsArray = $connection->fetchAll($select);
    	$rowArray =$connection->fetchRow($select);

    	$orderInfo = $rowArray;//$rowArray['entity_id'];

    	return $orderInfo;
    }

    /**
    Summary ���锟斤拷锟藉嘲锟斤拷������锟斤拷锟斤拷锟界��锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
    Summary ���锟界����х��������锟斤拷锟斤拷��碉拷锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
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
    		print "娑�锟界��锟斤拷锟姐��锟姐��锟姐��锟斤拷���锟�";
    		exit();
    	}
    	else
    	{
    		//print "锟斤拷��ワ拷���锟姐��锟斤拷锟斤拷���锟斤拷";
    		//婵★拷锟斤拷锟斤拷锟姐��锟藉��锟藉��锟藉��锟斤拷锟斤拷���锟斤拷锟斤拷锟芥�╋拷���锟芥��锟界��锟斤拷锟斤拷锟斤拷��帮拷���锟斤拷锟斤拷��ワ拷锟斤拷锟斤拷娴ｏ拷.
    		if($Timestamp+TIMESTEMP > time())
    		{
    			//妤�锟界��锟�
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
     Summary ���锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷娣�锟�.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-05.
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
    		print '锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟藉��锟借��锟斤拷锟斤拷���璐�缁���达拷锟�';
    		exit();
    	}
    	return $reValue;
    }

    /**
    Summary ���锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷娣�锟�.
    Author  ���锟�Henry.
    Add Time���锟�2014-09-05.
    **/
    public function SendSMSAction()
    {
    	    $message=$_POST['text'];
     	    $telphone =$_POST['phnum'];
    	    header("Content-Type: text/html; charset=utf-8");
// 	        print $_GET['phnum'];
	        
// 	        exit();
	        $uid = 'SDK2101';
	        
	        $passwd = '123456';

	        $message ="您好；您验证码是123456 请务泄漏.【杜蕾斯】";//&encode=gb2312
	        
	        $message =rawurlencode($message);

	        $gateway = "http://api.bjszrk.com/sdk/BatchSend.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$telphone}&Content={$message}&Cell=&SendTime=";
	        $reValue=true;
	        if($telphone !='')
	        {
	        	$result = file_get_contents($gateway);

	        	if(0 <$result)
	        	{
	        		echo "".date("Y-m-d H:i:s");
	        	}
	        }
	        else
	        {
	        	$reValue=false;
	          
	        }
	        print '<!###'.$reValue.'###!>';
	        exit();
	        return $reValue;
    }

    /**
     Summary ���锟斤拷锟藉嘲锟斤拷������锟斤拷锟斤拷���锟斤拷楠���帮拷锟斤拷锟斤拷XML���锟界��锟芥��锟�.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-19.
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
     Summary ���锟斤拷锟斤拷锟斤拷���锟姐�ワ拷锝�锟斤拷锟斤拷锟�.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-19.
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
    	 		'projectGuid' => '3e618ae6锟斤拷锟�351e锟斤拷锟�e411锟斤拷锟�8444锟斤拷锟�00155d282801',
    	 		'userGuid' => '5853b03d锟斤拷锟�ed22锟斤拷锟�e411锟斤拷锟�8d9d锟斤拷锟�00155d282801',
    	 		'order' => $order
    	 ));

     	 print $pp;
    }
    
    public function GetOrderDetailInfo($order_id)
    {
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
    	$select = $connection->select()
    	->from('sales_flat_order_item', array('*'))->where('order_id=?',$order_id);
    	$rowArray =$connection->fetchAll($select);
    	return $rowArray;
    }
    /**
     Summary ���锟斤拷锟斤拷锟斤拷锟借��锟斤拷锟斤拷锟斤拷��ワ拷锝�锟斤拷锟斤拷锟�.
     Author  ���锟�Henry.
     Add Time���锟�2014-09-19.
     **/
    public function PackageAction()
    {
    	header("Content-Type: text/html; charset=UTF-8");
    	$postAddress='http://116.247.104.206/order.ashx';

    	$order_id=31;
    	$orderinfo = $this->getorderbyid($order_id);

    	$user_id = $orderinfo['customer_id'];
    	$userInfo = $this->GetUserInfo($user_id);
        
        $useraddress=$this->GetUserShppingAddress($userInfo->GetData('default_shipping'));
    	$username = $userInfo->GetData('firstname').'.'.$userInfo->GetData('lastname');
    	$orderdetailInfor=$this->GetOrderDetailInfo($order_id);
 
        $tel = $useraddress->GetData('fax');
        $mobile =$useraddress->GetData('telephone');
		$payamount = $orderinfo['subtotal'];
    	$timeS =time();
    	$orderDeital="<?xml version='1.0' encoding='UTF-8'?>
    			<request>
    			<action>order</action>
    			<Timestamp>".$timeS."</Timestamp>
    			<orderid>".$order_id."</orderid>
    					<orderfrom>0</orderfrom>
    					<buyername>".$username."</buyername>
    					<note></note>
    							<receiver>
	    							<name>".$username."</name>
	    							<tel>".$tel."</tel>
	    							<mobile>".$mobile."</mobile>
	    							<province>".$useraddress->GetData('region')."</province>
	    							<city>".$useraddress->GetData('city')."</city>
	    							<district>".$useraddress->GetData('region')."</district>
	    							<address>".$useraddress->GetData('street')."</address>
	    							<zipcode>".$useraddress->GetData('postcode')."</zipcode>
    							</receiver>
    							<barcode></barcode>
    							<itemcount>2</itemcount>
	    						<items>";
								foreach($orderdetailInfor as $or)
								{
									$orderDeital = $orderDeital."	
									<item>
    									<itemcode>".$or['barcode']."</itemcode>
    									<itemspec></itemspec>
										<price>".$or['base_price']."</price>
    									<num>1</num>
    								</item>";
								}
	    						$orderDeital .="
	    						</items>
    							<pay>
	    							<ispayed>1</ispayed>
	    							<paydate>".$orderinfo['created_at']."</paydate>
	    							<payamount>".$orderinfo['subtotal']."</payamount>
    							</pay>
    							</request>";

// print $orderDeital;
// exit();
        
     	$encrypt = md5($order_id.$timeS.$payamount.$tel.$mobile.BCKEY);
		$url = 'http://116.247.104.206/order.ashx?&Encrypt='.$encrypt;
		
		$header = "Content-type:application/x-www-form-urlencoded;charset=utf-8";
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $orderDeital);
		
		$response = curl_exec($ch);
		
		if(curl_errno($ch)){
		
		    print curl_error($ch);
		
		}
		
		curl_close($ch); 

		echo $response;
    	print $content;

    }
    
	/**
     Summary  更新订单接口.
     Author   Henry.
     Add Time 014-09-19.
     **/
	public function UpdateOrderStatusAction()
	{
           
            $order_id = 30;//$_POST['order_id'];
			$status='已发货';
	       
			$_SOAP = new SoapClient('http://124.205.25.148/m/index.php/api/soap/?wsdl');
			$sessionId = $_SOAP->login('Henry', '000000');
			
 			return var_export($sessionId);
			 
			$shippId = $_SOAP->call($sessionId, 'sales_order.addComment',
			array($order_id,$status, $comment = null, $notify = false) );
           
			echo var_export($shippId);

			$_SOAP->endSession($sessionId);
	
		    return var_export($sessionId);
	
	}
    // ������post璇锋��
    // @param string $url 璇锋����板��
    // @param array $post_data post�����煎�规�版��
    // @return string
    function sendPost($url, $post_data){
    
    	// http_build_query()
    	// ������URL-encode涔�������璇锋��瀛�绗�涓�
    	//
    	// 澶�娉�锛�
    	// php5.3���������绗���ㄧ�����&amp;锛�濡���������������″�ㄤ�����php5.3锛���ｄ��灏变��浼���洪�����
    	// 浣����濡���������������″�ㄦ��java���tomcat������������锛���ｄ��&amp;�����藉氨浼�澶�������璇����
    	// 浠ヤ�����褰㈠����藉����垮�����璇�
    	// http_build_query($post_data, '', '&');
    
    	// stream_context_create()
    	// ���寤哄苟杩����涓�涓�娴����璧�婧�
    
    	        $username='username';
    			$password='password';
    			$postData = http_build_query($post_data, '', '&');
    			$options = array(
    			'http' =>array(
    			'method'=>"POST",
    			'header'=>"Accept-language: en\r\n".
    			"Cookie: foo=bar\r\n".
    			"Authorization: Basic " . base64_encode("$username:$password").'\r\n',
    					'content-type'=>"multipart/form-data",
    					'content' => $postData,
    					'timeout' => 15 * 60//瓒���舵�堕�达�����浣�:s锛�
    			)
    	);
    	//���寤哄苟杩����涓�涓�娴����璧�婧�
    			$context = stream_context_create($options);
    					$result = file_get_contents($url, false, $context);
    
    					print  $result;
    					return $result;
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
	const WAIT_PAYMENT = '缁�锟藉�帮拷娴�锟藉��锟�';
	const COMPLETE = '��癸拷锟斤拷锟�';
	const CLOSE = '锟斤拷��斤拷锟�';
	const CANCEL = '锟斤拷锟藉��锟�';
	const HOLD_ON = '锟斤拷锟界�э拷';
	const No = 0;
	const Yes = 1;
}
/**
 * @Summary :锟斤拷��匡拷锟界猾璇诧拷锟�.
 * @author  :Henry.
 * @Add time:2014-09-05.
 */
class Enum_AddressType
{
	const Billing = 0;
	const Shipping =1;
}
/**
 * @Summary :娴���锟斤拷锟斤拷���锟斤拷��癸拷娴ｏ拷.
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













