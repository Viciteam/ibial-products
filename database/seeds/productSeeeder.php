<?php

use Illuminate\Database\Seeder;

use App\Data\Repositories\Property\PropertyRepository;
use App\Data\Repositories\Property\PropertyMetaRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class productSeeeder extends Seeder
{

    private $propertyRepo;
    private $propertyMeta;

    public function __construct(
        PropertyRepository $propertyRepo,
        PropertyMetaRepository $propertyMeta
    ){
        $this->property = $propertyRepo;
        $this->property_meta = $propertyMeta;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(
        PropertyRepository $propertyRepo,
        PropertyMetaRepository $propertyMeta
    )
    {
        $this->property = $propertyRepo;
        $this->property_meta = $propertyMeta;
        // prepare status
        $status = ["draft", "published", "draft"];

        // $pricing
        $pricing = ["paid", "free"];

        // metas
        $category = [
            "Dating",
            "Family",
            "Fatherhood",
            "Friendship",
            "Marriage",
            "Motherhood",
            "Parenting",
            "Weddings",
        ];

        $features = [
            "Touch Screen Ready",
            "Integrated Customer Rewards Program",
            "Easy Promotional & Price Updates",
            "Easy to Use Data Entry / Inquiry Screens",
            "On Screen Keyboard can work just like & better than your cash register",
            "Orders, Quotes, Layaways, Due Bills",
            "Recurring Invoices, Auto Invoice Monthly, Quarterly, Yearly",
            "Customer Contract Pricing, Cost Plus Pricing, Promos, Item Mix & Match,",
            "Price Levels, Pricing by Vendor, Membership Pricing & Promos, Pricing by Purchase History, Two Fer Pricing, Three Fer Pricing",
            "Emergency Stand Alone Mode",
            "Training Mode",
            "Advanced Auto Purchase Order System",
            "Purchase by Sales History",
            "Receive P.O.’s by Scanning",
            "Multiple Appointment Scheduler",
            "40,000 Programmable Sales Screen Buttons",
            "Up to 1000 Menus with 40 Buttons each",
            "Select Text, Picture, SKU, Color and Sub-Menu for each Button",
            "Fast Pay Buttons: Cash, Credit Card, EBT, $100, $50, $20, $10, $5, $1",
            "Restaurant Version with Kitchen Printers, Deliveries, Carry Outs",
            "Full System Security and Accountability",
            "Item Disposition Codes for Reordering",
            "Master Item Quantity Break Down",
            "Membership Cards and Gift Cards",
            "Report of Cancels, Edits, Voids",
            "Reprint Any Closeout Report",
            "Accounts Receivable (optional)",
            "Accounts Payable (optional)",
            "General Ledger (optional)",
            "Multi–Site / Multi-Location (optional)",
            "Employee Time Clock",
            "Customer Purchase and Check History",
            "Service Module with History",
            "Expense Paid Outs and Accountability",
            "Phone Messaging, Inter-Office Messaging, Reminders",
            "Gift Receipts, Email Receipts, Email Statements",
            "Targeted Mailings by Purchase History",
            "Comprehensive Inventory Control",
            "Receive Products to Stock by Scanning",
            "Import Liquor Data File Import",         
            "Print Liquor Shelf Labels with Bar Codes",
            "Online Liquor Ordering by Scanning",
        ];

        $interest = [
            "Advertising",
            "Agriculture",
            "Architecture",
            "Aviation",
            "Banking",
            "Business",
            "Construction",
            "Design",
            "Economics",
            "Engineering",
        ];

        

        $limit = 5;

        for ($i=0; $i <= $limit ; $i++) { 

            $max_status = count($status) - 1;
            $max_pricing = count($pricing) - 1;
            $max_category = count($category) - 1;
            $max_features = count($features) - 1;
            $max_interest = count($interest) - 1;

            $dstatus = $status[rand(0, $max_status)];
            $dpricing = $pricing[rand(0, $max_pricing)];

            // build meta
            $cat_limit = rand(6, 20);
            $new_cat = [];
            for ($nc=0; $nc <= $cat_limit; $nc++) { 
                $dcategory = $category[rand(0, $max_category)];
                array_push($new_cat, $dcategory);
            }

            $cat_feat = rand(6, 20);
            $new_feat = [];
            for ($nf=0; $nf <= $cat_feat; $nf++) { 
                $dfeatures = $features[rand(0, $max_features)];
                array_push($new_feat, $dfeatures);
            }

            $cat_interest = rand(6, 20);
            $new_interest = [];
            for ($ni=0; $ni <= $cat_interest; $ni++) { 
                $dinterest = $interest[rand(0, $max_interest)];
                array_push($new_interest, $dinterest);
            }

            $id = DB::table('product')->insertGetId([
                "name" => "Sample title ".$i,
                "sku" => $this->skuGenerator(),
                "description" => "this is a description",
                "image" => json_encode(["image1", "image1"]),
                "status" => $dstatus,
                "ownerid" => rand(0, 120423),
                "storeid" => rand(0, 120423),
                "pricing" => $dpricing,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            foreach ($new_cat as $catkey => $catvalue) {
                DB::table('product_meta')->insertGetId([
                    "productid" => $id,
                    "metakey" => "category",
                    "metavalue" => $catvalue,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }

            foreach ($new_feat as $featkey => $featvalue) {
                DB::table('product_meta')->insertGetId([
                    "productid" => $id,
                    "metakey" => "features",
                    "metavalue" => $featvalue,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }

            foreach ($new_interest as $interestkey => $interestvalue) {
                DB::table('product_meta')->insertGetId([
                    "productid" => $id,
                    "metakey" => "interest",
                    "metavalue" => $interestvalue,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }


        }


    }

    /**
     * SKU Generator
     */
    public function skuGenerator()
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";  
        srand((double)microtime()*1000000); 
        $i = 0; 
        $pass = '' ; 

        while ($i <= 7) { 
            $num = rand() % 33; 
            $tmp = substr($chars, $num, 1); 
            $pass = $pass . $tmp; 
            $i++; 
        } 

        return $pass; 
    }
}
