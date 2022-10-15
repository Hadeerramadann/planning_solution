<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class usersController extends Controller
{

  public function index()
    {

      return view('welcome');
    }
    public function get_domain_suggest(Request $request)
    {
          $domain_name=$request->domain_name;
          dd($domain_name);
          $API_KEY 	= "gHA5TXx16HL4_CxPZ4evRUsJn8Mqxmg26Z2";
          $API_SECRET = "LXsocYifqsW6SsoHj5iLMu";
          $header = array(
            'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.''
          );
          $ch = curl_init();
          $timeout=60;

          $suggestUrl = "https://api.godaddy.com/v1/domains/suggest?query=".$domain_name."&limit=5";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $suggestUrl);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
          curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
          $result = curl_exec($ch);
          curl_close($ch);
          $suggestDomain = json_decode($result, true);
          return view('welcome',compact('suggestDomain'));
    }

    //*************** */
    public function store(Request $request)
    {
        $domain_provider=$request->domain_provider;

        // $domain_name=$request->domain_name.'.'.$domain_provider.'.com';
        $domain_name=$request->domain_name;
        $name=$request->name;
        $address=$request->address;
        $phone=$request->phone;
        $email=$request->email;


        $domain_exist=User::where('domain_name',$domain_name)->get();
        // dd($domain_exist);
       
        // if( $domain_exist->isEmpty()  ){
           
        //         $User=User::create($request->except('domain_name'));
               
        //         $User->domain_name=$domain_name;
        //         $User->save();
        //         session()->flash('message', 'your domain ['.$domain_name.' ] created successfly');
        //          return back();
           

        // }
        // else{
        //     session()->flash('message', 'domain name already exist');
          
        //     return redirect()->back()->withInput();

        // }
       
       // curl -X GET -H "Authorization: sso-key [gHA5TXx16HL4_CxPZ4evRUsJn8Mqxmg26Z2]:[API_SECRET]" "https://api.godaddy.com/v1/domains/available?domain=example.guru"
       $API_KEY 	= "gHA5TXx16HL4_CxPZ4evRUsJn8Mqxmg26Z2";
       $API_SECRET = "LXsocYifqsW6SsoHj5iLMu";

    //   ****************
      if(isset($domain_name)) {
	
	
        $domain_name = str_replace('www.', '', $domain_name);
        $domain_name = str_replace('www', '', $domain_name);
        $domain_name = str_replace('/', '', $domain_name);
        $domain_name = str_replace(':', '', $domain_name);
        $domain_name = str_replace('https', '', $domain_name);
        $domain_name = str_replace('http', '', $domain_name);
        $domain_name = trim($domain_name);
        $domain_name = filter_var($domain_name, FILTER_SANITIZE_URL);
    
        $domain = explode('.',$domain_name);
        // if(!$domain[1])
        //     $domain=$domain[0].'.com';
        // else
       
            $domain=$domain_name;
            $url = "https://api.godaddy.com/v1/domains/available?domain=".$domain;


            // *******************



           
              $header = array(
                      'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.'',
                     
                  );
                  $ch = curl_init();
              
                  $timeout=60;
              
                  curl_setopt($ch, CURLOPT_URL, $url);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
             
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                  //execute call and return response data.
                  $result = curl_exec($ch);
                  //close curl connection
                  curl_close($ch);
                  // decode the json response
                  $PurchaseDomain = json_decode($result, true);
         
        if($PurchaseDomain['available']==1 || $PurchaseDomain['available']==true){
          
          // session()->flash('message',"Congrats! Your domain '.$domain.'is available");
      // *************

        $bodyContent = '{
              "consent": {
                  "agreedAt": "'.date("Y-m-d\TH:i:s\Z").'",
                  "agreedBy": "127.0.0.1",
                  "agreementKeys": [
                    "DNRA"
                  ]
                },
                "contactAdmin": {
                  "addressMailing": {
                    "address1": "'.$address.'",
                    "address2": "Lucknow",
                    "city": "Lucknow",
                    "country": "IN",
                    "postalCode": "226010",
                    "state": "Uttar pradesh"
                  },
                  "email": "'.$email.'",
                  "fax": "",
                  "jobTitle": "Full Stack Developer",
                  "nameFirst": "'.$name.'",
                  "nameLast": "Vishwakarma",
                  "nameMiddle": "",
                  "organization": "Wizweb Technology",
                  "phone": "+20.'.$phone.'"
                  },
                  "contactBilling": {
                  "addressMailing": {
                  "address1": "'.$address.'",
                    "address2": "Lucknow",
                    "city": "Lucknow",
                    "country": "IN",
                    "postalCode": "226010",
                    "state": "Uttar pradesh"
                  },
                  "email": "'.$email.'",
                  "fax": "",
                  "jobTitle": "Full Stack Developer",
                  "nameFirst": "'.$name.'",
                  "nameLast": "Vishwakarma",
                  "nameMiddle": "",
                  "organization": "Wizweb Technology",
                  "phone": "+20.'.$phone.'"
                  },
                  "contactRegistrant": {
                  "addressMailing": {
                    "address1": "'.$address.'",
                    "address2": "Lucknow",
                    "city": "Lucknow",
                    "country": "IN",
                    "postalCode": "226010",
                    "state": "Uttar pradesh"
                  },
                  "email": "'.$email.'",
                  "fax": "",
                  "jobTitle": "Full Stack Developer",
                  "nameFirst": "'.$name.'",
                  "nameLast": "Vishwakarma",
                  "nameMiddle": "",
                  "organization": "Wizweb Technology",
                  "phone": "+20.'.$phone.'"
                  },
                  "contactTech": {
                  "addressMailing": {
                    "address1": "Gomti Nagar",
                    "address2": "Lucknow",
                    "city": "Lucknow",
                    "country": "IN",
                    "postalCode": "226100",
                    "state": "Uttar pradesh"
                  },
                  "email": "'.$email.'",
                  "fax": "",
                  "jobTitle": "Full Stack Developer",
                  "nameFirst": "'.$name.'",
                  "nameLast": "Vishwakarma",
                  "nameMiddle": "",
                  "organization": "Wizweb Technology",
                  "phone": "+91.9807321564"
                  },
                  "domain": "'.$domain.'",
                  "nameServers": [
                  "ns50.domaincontrol.com",
                  "ns60.domaincontrol.com"
                  ],
                  "period": 2,
                  "privacy": false,
                  "renewAuto": true
            }';
            
          
            
            
              $url2 = "https://api.godaddy.com/v1/domains/purchase";
              // $url ="https://api.godaddy.com/v1/domains/purchase/validate";
              $header2 = array(
                  'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.'',
                  "Content-Type: application/json",
                  'Accept: applicat1ion/json'
              );
              $ch2 = curl_init();
          
              $timeout2=60;
          
              curl_setopt($ch2, CURLOPT_URL, $url2);
              curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
              curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, $timeout2);
              curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);  
              curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'POST'); // Values: GET, POST, PUT, DELETE, PATCH, UPDATE 
              curl_setopt($ch2, CURLOPT_POSTFIELDS, $bodyContent);
              //curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch2, CURLOPT_HTTPHEADER, $header2);
              //execute call and return response data.
              $result2 = curl_exec($ch2);
              //close curl connection
              curl_close($ch2);
              // decode the json response
              $PurchaseDomain2 = json_decode($result2, true);
          // dd($PurchaseDomain2);
              if($PurchaseDomain2['code']){
                // $price = $PurchaseDomain2['total']/1000000;
                
                  session()->flash('message', $PurchaseDomain2['message']);
                
                return redirect()->back()->withInput();	

              } else if($PurchaseDomain2['orderId']) {
                  $price = $PurchaseDomain2['total']/1000000;
                  session()->flash('message', 'Congrats! Your domain ('.$domain.') is registered. <br><p>'.$PurchaseDomain['currency'].$price);
                
                  return redirect()->back()->withInput();	
              }
          


      // ************
        
        } 
        else if($PurchaseDomain['code']) {
         
          session()->flash('message',$PurchaseDomain['message']);
      
          return redirect()->back()->withInput();
        }
               else if($PurchaseDomain['available']=='' || $PurchaseDomain['available']==0) {
              
              session()->flash('message',"Sorry! This domain '.$domain.'is already registered");
          
              return redirect()->back()->withInput();
            }
            
           else {
      
            session()->flash('message',"Please enter any domain keyword");
          
            return redirect()->back()->withInput();
          }
        
      
        // **********************
        
      //   $bodyContent = '{
      //    "consent": {
      //       "agreedAt": "'.date("Y-m-d\TH:i:s\Z").'",
      //       "agreedBy": "127.0.0.1",
      //       "agreementKeys": [
      //         "DNRA"
      //       ]
      //     },
      //     "contactAdmin": {
      //       "addressMailing": {
      //         "address1": "'.$address.'",
      //         "address2": "Lucknow",
      //         "city": "Lucknow",
      //         "country": "IN",
      //         "postalCode": "226010",
      //         "state": "Uttar pradesh"
      //       },
      //       "email": "'.$email.'",
      //       "fax": "",
      //       "jobTitle": "Full Stack Developer",
      //       "nameFirst": "'.$name.'",
      //       "nameLast": "Vishwakarma",
      //       "nameMiddle": "",
      //       "organization": "Wizweb Technology",
      //       "phone": "+20.'.$phone.'"
      //       },
      //       "contactBilling": {
      //       "addressMailing": {
      //        "address1": "'.$address.'",
      //         "address2": "Lucknow",
      //         "city": "Lucknow",
      //         "country": "IN",
      //         "postalCode": "226010",
      //         "state": "Uttar pradesh"
      //       },
      //       "email": "'.$email.'",
      //       "fax": "",
      //       "jobTitle": "Full Stack Developer",
      //       "nameFirst": "'.$name.'",
      //       "nameLast": "Vishwakarma",
      //       "nameMiddle": "",
      //       "organization": "Wizweb Technology",
      //       "phone": "+20.'.$phone.'"
      //       },
      //       "contactRegistrant": {
      //       "addressMailing": {
      //         "address1": "'.$address.'",
      //         "address2": "Lucknow",
      //         "city": "Lucknow",
      //         "country": "IN",
      //         "postalCode": "226010",
      //         "state": "Uttar pradesh"
      //       },
      //       "email": "'.$email.'",
      //       "fax": "",
      //       "jobTitle": "Full Stack Developer",
      //       "nameFirst": "'.$name.'",
      //       "nameLast": "Vishwakarma",
      //       "nameMiddle": "",
      //       "organization": "Wizweb Technology",
      //       "phone": "+20.'.$phone.'"
      //       },
      //       "contactTech": {
      //       "addressMailing": {
      //         "address1": "Gomti Nagar",
      //         "address2": "Lucknow",
      //         "city": "Lucknow",
      //         "country": "IN",
      //         "postalCode": "226100",
      //         "state": "Uttar pradesh"
      //       },
      //       "email": "'.$email.'",
      //       "fax": "",
      //       "jobTitle": "Full Stack Developer",
      //       "nameFirst": "'.$name.'",
      //       "nameLast": "Vishwakarma",
      //       "nameMiddle": "",
      //       "organization": "Wizweb Technology",
      //       "phone": "+91.9807321564"
      //       },
      //       "domain": "'.$domain.'",
      //       "nameServers": [
      //       "ns50.domaincontrol.com",
      //       "ns60.domaincontrol.com"
      //       ],
      //       "period": 2,
      //       "privacy": false,
      //       "renewAuto": true
      //  }';
    
    
      
       
      //   $url = "https://api.godaddy.com/v1/domains/purchase";
      //   // $url ="https://api.godaddy.com/v1/domains/purchase/validate";
      //   $header = array(
      //       'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.'',
      //       "Content-Type: application/json",
      //       'Accept: applicat1ion/json'
      //   );
      //   $ch = curl_init();
    
      //   $timeout=60;
    
      //   curl_setopt($ch, CURLOPT_URL, $url);
      //   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
      //   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // Values: GET, POST, PUT, DELETE, PATCH, UPDATE 
      //   curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyContent);
      //   //curl_setopt($ch, CURLOPT_POST, true);
      //   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      //   //execute call and return response data.
      //   $result = curl_exec($ch);
      //   //close curl connection
      //   curl_close($ch);
      //   // decode the json response
      //   $PurchaseDomain = json_decode($result, true);
    
      //   if($PurchaseDomain['code']){
           
      //       session()->flash('message', $PurchaseDomain['message']);
          
      //      return redirect()->back()->withInput();	

      //   } else if($PurchaseDomain['orderId']) {
      //       $price = $PurchaseDomain['total']/1000000;
      //        session()->flash('message', 'Congrats! Your domain ('.$domain.') is registered. <br><p>'.$PurchaseDomain['currency'].$price);
          
      //       return redirect()->back()->withInput();	
      //   }
    
    
    }

// **********************
            
        }           
                    
    
}
