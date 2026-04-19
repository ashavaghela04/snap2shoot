<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\PortfolioItem;
use App\Models\Review;
use App\Models\Booking;
use App\Models\TeamMember;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(['email' => 'admin@snap2shoot.com'], [
            'name'     => 'Admin',
            'password' => Hash::make('admin123'),
        ]);

        // Services
        $services = [
            ['name'=>'Royal Wedding Coverage','slug'=>'royal','icon'=>'fas fa-crown','price_label'=>'Starting from ₹1,25,000','description'=>'Our premium package for couples who want complete coverage of their special day with the highest quality service.','features'=>['Full day coverage (12+ hours)','Two professional photographers','Pre-wedding consultation','Engagement session (2 hours)','800+ high-resolution edited photos','Premium leather-bound album (50 pages)','All digital images on USB drive','Online gallery for 1 year','20x30\" canvas print','Priority booking for future events'],'image_url'=>'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&q=80','sort_order'=>1],
            ['name'=>'Pre-Wedding Shoot','slug'=>'prewedding','icon'=>'fas fa-heart','price_label'=>'Starting from ₹35,000','description'=>'Capture the romance and excitement before your big day with a personalized pre-wedding photoshoot.','features'=>['4-hour photoshoot session','2 location changes','Professional styling guidance','200+ edited high-resolution photos','Online gallery for 6 months','5 social media optimized images','1 outfit change','Basic makeup assistance','Digital images on USB','10 printed 5x7\" photos'],'image_url'=>'https://images.unsplash.com/photo-1529636798458-92182e662485?w=800&q=80','sort_order'=>2],
            ['name'=>'Cinematic Wedding Film','slug'=>'cinematic','icon'=>'fas fa-video','price_label'=>'Starting from ₹75,000','description'=>'A beautifully crafted film that tells the story of your wedding day with cinematic quality and emotional depth.','features'=>['10-15 minute feature film','2 cinematographers','Drone footage (where permitted)','Professional audio recording','Licensed music score','Color grading and editing','3-5 minute highlight video','Full ceremony recording','4K resolution delivery','Blu-ray/DVD copies'],'image_url'=>'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=800&q=80','sort_order'=>3],
            ['name'=>'Maternity Shoot','slug'=>'maternity','icon'=>'fas fa-baby','price_label'=>'Starting from ₹25,000','description'=>'Celebrate the miracle of life with a beautiful maternity photoshoot that captures this special time.','features'=>['3-hour photoshoot session','Studio or outdoor location','Professional lighting setup','100+ edited high-resolution photos','Partner and family included','Props and drapes provided','Online gallery for 6 months','Digital images on USB','5 printed 8x10\" photos','Social media images'],'image_url'=>'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&q=80','sort_order'=>4],
            ['name'=>'Engagement Shoot','slug'=>'engagement','icon'=>'fas fa-gem','price_label'=>'Starting from ₹20,000','description'=>'Announce your engagement with beautiful photos that capture your love story.','features'=>['2-hour photoshoot session','1 location of your choice','75+ edited high-resolution photos','Online gallery for 3 months','3 social media optimized images','Digital images on USB','Basic retouching','Print release','Quick turnaround (7 days)'],'image_url'=>'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&q=80','sort_order'=>5],
        ];
        foreach ($services as $s) { Service::firstOrCreate(['slug'=>$s['slug']], $s); }

        // Portfolio
        $portfolio = [
            ['title'=>'Royal Gujarati Wedding','location'=>'Ahmedabad Palace','category'=>'wedding','is_featured'=>true,'image_url'=>'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&q=80','description'=>'Traditional Ceremony','sort_order'=>1],
            ['title'=>'Sunset Pre-Wedding','location'=>'Udaipur Palace','category'=>'prewedding','is_featured'=>true,'image_url'=>'https://images.unsplash.com/photo-1529636798458-92182e662485?w=800&q=80','description'=>'Romantic Session','sort_order'=>2],
            ['title'=>'Modern Wedding','location'=>'Vadodara','category'=>'wedding','is_featured'=>true,'image_url'=>'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=800&q=80','description'=>'Contemporary Celebration','sort_order'=>3],
            ['title'=>'Golden Hour Maternity','location'=>'Studio Session','category'=>'maternity','is_featured'=>true,'image_url'=>'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&q=80','description'=>'Intimate Moments','sort_order'=>4],
            ['title'=>'Traditional Rajasthani Wedding','location'=>'Jodhpur','category'=>'traditional','is_featured'=>false,'image_url'=>'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&q=80','description'=>'Cultural Celebration','sort_order'=>5],
            ['title'=>'Engagement Ceremony','location'=>'Surat','category'=>'engagement','is_featured'=>false,'image_url'=>'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&q=80','description'=>'Family Celebration','sort_order'=>6],
            ['title'=>'Mehendi & Haldi Ceremony','location'=>'Ahmedabad','category'=>'wedding','is_featured'=>false,'image_url'=>'https://images.unsplash.com/photo-1561049501-e1f96bdd98fd?w=800&q=80','description'=>'Pre-Wedding Rituals','sort_order'=>7],
            ['title'=>'Destination Beach Wedding','location'=>'Goa','category'=>'wedding','is_featured'=>false,'image_url'=>'https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=800&q=80','description'=>'Beach Celebration','sort_order'=>8],
        ];
        foreach ($portfolio as $p) { PortfolioItem::firstOrCreate(['title'=>$p['title'],'category'=>$p['category']],$p); }

        // Reviews
        $reviews = [
            ['client_name'=>'Priya & Rohan','event_type'=>'wedding','event_location'=>'Ahmedabad','event_year'=>'2023','rating'=>5,'review_text'=>'Rajveer captured our wedding so beautifully that we relive the emotions every time we look at our album. His attention to detail and ability to capture candid moments is remarkable!','client_image_url'=>'https://ui-avatars.com/api/?name=Priya+Rohan&background=c9a24d&color=fff','status'=>'approved'],
            ['client_name'=>'Ananya & Karan','event_type'=>'video','event_location'=>'Rajkot','event_year'=>'2023','rating'=>5,'review_text'=>'From our pre-wedding shoot to the big day, Snap2Shoot delivered beyond our expectations. The cinematic wedding film had our entire family in tears of joy. Highly recommended!','client_image_url'=>'https://ui-avatars.com/api/?name=Ananya+Karan&background=7a1f2b&color=fff','status'=>'approved'],
            ['client_name'=>'Meera & Vikram','event_type'=>'prewedding','event_location'=>'Udaipur','event_year'=>'2023','rating'=>5,'review_text'=>'Our pre-wedding shoot at Udaipur Palace was a dream come true. The photos are absolutely stunning. Every single shot tells a beautiful story.','client_image_url'=>'https://ui-avatars.com/api/?name=Meera+Vikram&background=c9a24d&color=fff','status'=>'approved'],
            ['client_name'=>'Sunita Patel','event_type'=>'maternity','event_location'=>'Ahmedabad','event_year'=>'2024','rating'=>5,'review_text'=>'The maternity shoot was so comfortable and beautiful. They made me feel like a queen. The photos are timeless and I treasure them forever.','client_image_url'=>'https://ui-avatars.com/api/?name=Sunita+Patel&background=7a1f2b&color=fff','status'=>'approved'],
            ['client_name'=>'Rahul Verma','event_type'=>'wedding','event_location'=>'Surat','event_year'=>'2024','rating'=>5,'review_text'=>'Absolutely stunning photos! The team was so professional and friendly. They captured every moment perfectly.','client_image_url'=>'https://ui-avatars.com/api/?name=Rahul+Verma&background=c9a24d&color=fff','status'=>'pending'],
        ];
        foreach ($reviews as $r) { Review::firstOrCreate(['client_name'=>$r['client_name']], $r); }

        // Bookings
        $svc = Service::where('slug','royal')->first();
        $bookings = [
            ['client_name'=>'Amit Patel','client_email'=>'amit@example.com','client_phone'=>'+91 98765 11111','service_id'=>$svc?->id,'event_date'=>'2026-10-24','event_location'=>'Kankaria Lake, Ahmedabad','amount'=>125000,'status'=>'pending'],
            ['client_name'=>'Nisha Shah','client_email'=>'nisha@example.com','client_phone'=>'+91 98765 22222','service_id'=>$svc?->id,'event_date'=>'2026-11-15','event_location'=>'Rajkot Palace','amount'=>75000,'status'=>'confirmed'],
            ['client_name'=>'Rohit Kumar','client_email'=>'rohit@example.com','client_phone'=>'+91 98765 33333','service_id'=>$svc?->id,'event_date'=>'2026-12-08','event_location'=>'Vadodara','amount'=>35000,'status'=>'confirmed'],
        ];
        foreach ($bookings as $b) { Booking::firstOrCreate(['client_email'=>$b['client_email']], $b); }

        // Team
        $team = [
            ['name'=>'Rajveer Patel','role'=>'Lead Photographer & Founder','bio'=>'With 8+ years of experience, Rajveer specializes in cinematic storytelling and candid moments.','image_url'=>'https://ui-avatars.com/api/?name=Rajveer+Patel&background=7a1f2b&color=fff&size=200','instagram_url'=>'#','facebook_url'=>'#','sort_order'=>1],
            ['name'=>'Anjali Sharma','role'=>'Videographer & Editor','bio'=>"Anjali brings a filmmaker's eye to wedding videos, creating emotional cinematic narratives.",'image_url'=>'https://ui-avatars.com/api/?name=Anjali+Sharma&background=c9a24d&color=fff&size=200','instagram_url'=>'#','facebook_url'=>'#','sort_order'=>2],
            ['name'=>'Rahul Mehta','role'=>'Photographer & Drone Specialist','bio'=>'Rahul captures breathtaking aerial perspectives and specializes in traditional wedding photography.','image_url'=>'https://ui-avatars.com/api/?name=Rahul+Mehta&background=7a1f2b&color=fff&size=200','instagram_url'=>'#','facebook_url'=>'#','sort_order'=>3],
        ];
        foreach ($team as $t) { TeamMember::firstOrCreate(['name'=>$t['name']], $t); }

        // Settings
        $settings = [
            'studio_name'=>'Snap2Shoot','tagline'=>'Luxury Wedding Photography',
            'address'=>'123 MG Road, Near Law Garden, Ahmedabad, Gujarat 380009',
            'phone_primary'=>'+91 98765 43210','phone_secondary'=>'+91 98765 43211',
            'email_primary'=>'hello@snap2shoot.com','email_bookings'=>'bookings@snap2shoot.com',
            'working_hours'=>'Monday - Saturday: 10:00 AM - 7:00 PM','whatsapp_number'=>'919876543210',
            'instagram_url'=>'#','facebook_url'=>'#','pinterest_url'=>'#','youtube_url'=>'#',
            'years_experience'=>'8+','weddings_count'=>'500','clients_count'=>'10000',
            'hero_title'=>'Capturing Royal Moments Forever','hero_subtitle'=>'Luxury Wedding Photography',
            'hero_description'=>'Preserving your precious moments with timeless elegance, artistry, and the finest attention to detail.',
            'about_story'=>'Founded in 2015 by Rajveer Patel, Snap2Shoot began as a passion project to document the beautiful tapestry of Indian weddings.',
            'quote_text'=>"Photography is the story I fail to put into words. At Snap2Shoot, we don't just take pictures; we capture emotions, relationships, and the unspoken love that makes your wedding day uniquely yours.",
            'quote_author'=>'Rajveer, Lead Photographer',
        ];
        foreach ($settings as $k => $v) { Setting::firstOrCreate(['key'=>$k], ['value'=>$v]); }
    }
}
