<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$baseDir = __DIR__;
$storageFile = $baseDir . '/storage/complaints.json';
$uploadsDir = $baseDir . '/storage/uploads/';

if (!file_exists($storageFile)) {
    // Seed initial demo complaints for realistic presentation
    $seedData = [
        [
            'token' => 'AMC-2026-W04-1082',
            'category' => 'potholes',
            'category_title' => 'રસ્તા પરના ખાડા (Potholes & Road Damage)',
            'subcategory' => 'મોટો ખાડો (Deep Road Crater)',
            'ward' => 'નવરંગપુરા (Navrangpura)',
            'zone' => 'West Zone',
            'address' => 'Near Mithakhali Six Roads, Navrangpura, Ahmedabad',
            'lat' => 23.0338,
            'lng' => 72.5632,
            'description' => 'ભારે વરસાદના કારણે રસ્તા વચ્ચે મોટો ખાડો પડ્યો છે, વાહનચાલકો પડી જાય છે.',
            'citizen_name' => 'અમિતભાઈ પટેલ',
            'citizen_mobile' => '98250XXXXX',
            'photo_url' => 'assets/demo_pothole.jpg',
            'status' => 'In Progress',
            'created_at' => '2026-11-02 10:15:20',
            'assigned_officer' => 'રાજેશ વર્મા (Ward Inspector)',
            'officer_contact' => '+91 79 2539 1811',
            'resolution_remarks' => 'કામગીરી ચાલુ છે. ડામર પેચવર્ક આજે સાંજ સુધીમાં પૂર્ણ થશે.',
            'resolved_photo' => null,
            'resolved_at' => null,
            'rating' => null
        ],
        [
            'token' => 'AMC-2026-W09-2041',
            'category' => 'garbage',
            'category_title' => 'કચરો & સોલિડ વેસ્ટ (Garbage / Solid Waste)',
            'subcategory' => 'કચરાપેટી ઓવરફ્લો (Garbage Overflow)',
            'ward' => 'બોડકદેવ (Bodakdev)',
            'zone' => 'New West Zone',
            'address' => 'Opp. Judges Bungalow Road, Bodakdev, Ahmedabad',
            'lat' => 23.0452,
            'lng' => 72.5186,
            'description' => 'સોસાયટી બહાર કચરાપેટી બે દિવસથી ભરેલી છે, દુર્ગંધ આવે છે.',
            'citizen_name' => 'જિગ્નેશ શાહ',
            'citizen_mobile' => '98790XXXXX',
            'photo_url' => 'assets/demo_garbage.jpg',
            'status' => 'Resolved',
            'created_at' => '2026-11-01 09:30:00',
            'assigned_officer' => 'કિરીટ પંડ્યા (Sanitary Inspector)',
            'officer_contact' => '+91 79 2539 1812',
            'resolution_remarks' => 'ડોર-ટુ-ડોર ટીપર વાન દ્વારા કચરો સંપૂર્ણ સાફ કરવામાં આવ્યો છે.',
            'resolved_photo' => 'assets/demo_resolved.jpg',
            'resolved_at' => '2026-11-01 14:45:00',
            'rating' => 5
        ],
        [
            'token' => 'AMC-2026-W12-3094',
            'category' => 'streetlights',
            'category_title' => 'સ્ટ્રીટલાઇટ બંધ (Streetlight Outage)',
            'subcategory' => 'આખી લાઈન બંધ (All Streetlights Off)',
            'ward' => 'મણિનગર (Maninagar)',
            'zone' => 'South Zone',
            'address' => 'Kankaria Lake Gate 3 Road, Maninagar, Ahmedabad',
            'lat' => 22.9965,
            'lng' => 72.5986,
            'description' => 'કાંકરિયા રોડ પર ૩ પોલની લાઈટો છેલ્લા ૪ દિવસથી બંધ છે.',
            'citizen_name' => 'પ્રીતિબેન જોષી',
            'citizen_mobile' => '94260XXXXX',
            'photo_url' => 'assets/demo_streetlight.jpg',
            'status' => 'Submitted',
            'created_at' => '2026-11-03 08:00:10',
            'assigned_officer' => 'વિરેન મહેતા (Light Dept)',
            'officer_contact' => '+91 79 2539 1815',
            'resolution_remarks' => 'તપાસ હાથ ધરવામાં આવી છે.',
            'resolved_photo' => null,
            'resolved_at' => null,
            'rating' => null
        ]
    ];
    file_put_contents($storageFile, json_encode($seedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getComplaints() {
    global $storageFile;
    if (file_exists($storageFile)) {
        return json_decode(file_get_contents($storageFile), true) ?: [];
    }
    return [];
}

function saveComplaints($data) {
    global $storageFile;
    file_put_contents($storageFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true) ?? [];

switch ($action) {
    case 'get_metadata':
        echo json_encode([
            'categories' => [
                [
                    'id' => 'potholes',
                    'title' => 'રસ્તા પરના ખાડા (Roads & Potholes)',
                    'icon' => '🕳️',
                    'color' => '#dc2626',
                    'subcategories' => ['મોટો ખાડો (Deep Crater)', 'પેવિંગ બ્લોક તૂટેલા', 'રસ્તો બેસી ગયેલ', 'ડામર રોડ ડેમેજ']
                ],
                [
                    'id' => 'garbage',
                    'title' => 'કચરો & ગંદકી (Garbage / Solid Waste)',
                    'icon' => '🗑️',
                    'color' => '#ea580c',
                    'subcategories' => ['કચરાપેટી ઓવરફ્લો', 'જાહેર રસ્તા પર ગંદકી', 'મૃત પશુ ઉપાડવા બાબત', 'કચરા ગાડી ન આવવા બાબત']
                ],
                [
                    'id' => 'streetlights',
                    'title' => 'સ્ટ્રીટલાઇટ બંધ (Streetlight Outage)',
                    'icon' => '💡',
                    'color' => '#ca8a04',
                    'subcategories' => ['પોલ લાઈટ બંધ', 'વાયરિંગ ઓપન / શોર્ટ સર્કિટ', 'પોલ ડેમેજ / નમી ગયેલ', 'સમયસર લાઈટ ચાલુ ન થવી']
                ],
                [
                    'id' => 'water',
                    'title' => 'પાણી & ગટર (Water Supply & Drainage)',
                    'icon' => '🚰',
                    'color' => '#2563eb',
                    'subcategories' => ['ગંદુ પાણી આવવા બાબત', 'પાણીનું પ્રેશર ઓછું', 'ગટર ઓવરફ્લો / બેક મારવી', 'મેનહોલ ઢાંકણું તૂટેલ / ગાયબ']
                ],
                [
                    'id' => 'health',
                    'title' => 'આરોગ્ય & ફોગિંગ (Health & Mosquitoes)',
                    'icon' => '🦟',
                    'color' => '#16a34a',
                    'subcategories' => ['મચ્છરનો ઉપદ્રવ / ફોગિંગ જરૂર', 'પાણીના ખાબોચિયા દવા છંટકાવ', 'ખાદ્ય પદાર્થોમાં ભેળસેળ તપાસ']
                ],
                [
                    'id' => 'cattle',
                    'title' => 'રખડતા ઢોર & કૂતરા (Cattle Menace & Dogs)',
                    'icon' => '🐄',
                    'color' => '#7c3aed',
                    'subcategories' => ['રસ્તા પર રખડતી ગાયો/ઢોર', 'કૂતરા કરડવાનો ભય / ખસીકરણ']
                ]
            ],
            'zones' => [
                [
                    'name' => 'વેસ્ટ ઝોન (West Zone)',
                    'wards' => ['નવરંગપુરા (Navrangpura)', 'પાલડી (Paldi)', 'વાડજ (Vadaj)', 'ઉસ્માનપુરા (Usmanpura)', 'રાણીપ (Ranip)', 'સાબરમતી (Sabarmati)', 'સ્ટેડિયમ (Stadium)']
                ],
                [
                    'name' => 'ન્યુ વેસ્ટ ઝોન (New West Zone)',
                    'wards' => ['બોડકદેવ (Bodakdev)', 'સેટેલાઇટ (Satellite)', 'જોધપુર (Jodhpur)', 'વેજલપુર (Vejalpur)', 'ઘાટલોડિયા (Ghatlodia)', 'થલતેજ (Thaltej)', 'ગોટા (Gota)', 'ચાંદલોડિયા (Chandlodia)']
                ],
                [
                    'name' => 'સેન્ટ્રલ ઝોન (Central Zone)',
                    'wards' => ['ખાડિયા (Khadia)', 'શાહપુર (Shahpur)', 'જમાલપુર (Jamalpur)', 'દરીયાપુર (Dariapur)', 'અસારવા (Asarwa)', 'શાહીબાગ (Shahibaug)']
                ],
                [
                    'name' => 'સાઉથ ઝોન (South Zone)',
                    'wards' => ['મણિનગર (Maninagar)', 'ખોખરા (Khokhra)', 'દાણીલીમડા (Danilimda)', 'બેહરામપુરા (Behrampura)', 'ઇસનપુર (Isanpur)', 'વટવા (Vatva)', 'લાંભા (Lambha)']
                ],
                [
                    'name' => 'ઇસ્ટ ઝોન (East Zone)',
                    'wards' => ['બાપુનગર (Bapunagar)', 'નિકોલ (Nikol)', 'ઓઢવ (Odhav)', 'ગોમતીપુર (Gomtipur)', 'અમરાઈવાડી (Amraiwadi)', 'વિરાટનગર (Viratnagar)', 'વસ્ત્રાલ (Vastral)']
                ],
                [
                    'name' => 'નોર્થ ઝોન (North Zone)',
                    'wards' => ['નરોડા (Naroda)', 'કુબેરનગર (Kubernagar)', 'સરદારનગર (Sardarnagar)', 'મેઘાણીનગર (Meghaninagar)', 'સૈજપુર બોઘા (Saijpur Bogha)', 'ઇન્ડિયા કોલોની (India Colony)']
                ],
                [
                    'name' => 'સાઉથ વેસ્ટ ઝોન (South West Zone)',
                    'wards' => ['સરખેજ (Sarkhej)', 'મક્તમપુરા (Maktampura)', 'જોધપુર વેસ્ટ (Jodhpur West)']
                ]
            ],
            'helplines' => [
                'toll_free' => '155303',
                'call_center' => '079-25391811',
                'whatsapp' => '+91 99783 33303',
                'office_address' => 'Mahanagar Seva Sadan, Danapith, Ahmedabad - 380001'
            ]
        ]);
        break;

    case 'submit_complaint':
        $category = $input['category'] ?? $input['category_id'] ?? '';
        $category_title = $input['category_title'] ?? 'Civic Issue';
        $subcategory = $input['subcategory'] ?? '';
        $ward = $input['ward'] ?? 'નવરંગપુરા (Navrangpura)';
        $zone = $input['zone'] ?? 'West Zone';
        $address = $input['address'] ?? '';
        $lat = floatval($input['lat'] ?? 23.0225);
        $lng = floatval($input['lng'] ?? 72.5714);
        $description = trim($input['description'] ?? '');
        if (empty($description) && !empty($subcategory)) {
            $description = $subcategory;
        }
        $citizen_name = trim($input['citizen_name'] ?? 'નાગરિક');
        $citizen_mobile = trim($input['citizen_mobile'] ?? $input['citizen_phone'] ?? '98XXXXXXXX');
        $photo_data = $input['photo_base64'] ?? '';

        if (empty($category)) {
            echo json_encode(['success' => false, 'error' => 'કેટેગરી પસંદ કરવી જરૂરી છે']);
            break;
        }

        // Save photo if uploaded as base64
        $photo_url = null;
        if (!empty($photo_data) && strpos($photo_data, 'data:image') === 0) {
            $parts = explode(',', $photo_data);
            if (isset($parts[1])) {
                $decoded = base64_decode($parts[1]);
                $filename = 'complaint_' . time() . '_' . rand(100, 999) . '.jpg';
                file_put_contents($uploadsDir . $filename, $decoded);
                $photo_url = 'storage/uploads/' . $filename;
            }
        }

        // Generate Token: e.g. AMC-2026-W08-7491
        $randNum = rand(1000, 9999);
        $token = 'AMC-2026-W' . str_pad(rand(1, 48), 2, '0', STR_PAD_LEFT) . '-' . $randNum;
        $id = 'CMP-' . time() . '-' . rand(100, 999);

        $newComplaint = [
            'id' => $id,
            'token' => $token,
            'category' => $category,
            'category_id' => $category,
            'category_title' => $category_title,
            'subcategory' => $subcategory,
            'ward' => $ward,
            'zone' => $zone,
            'address' => $address ?: 'Ahmedabad, Gujarat',
            'lat' => $lat,
            'lng' => $lng,
            'description' => $description,
            'citizen_name' => $citizen_name,
            'citizen_mobile' => $citizen_mobile,
            'citizen_phone' => $citizen_mobile,
            'photo_url' => $photo_url,
            'status' => 'Submitted',
            'created_at' => date('Y-m-d H:i:s'),
            'assigned_officer' => 'નરેશ પટેલ (Ward Inspector)',
            'officer_contact' => '+91 79 2539 1811',
            'resolution_remarks' => null,
            'resolved_photo' => null,
            'resolution_photo' => null,
            'resolved_at' => null,
            'rating' => null
        ];

        $complaints = getComplaints();
        array_unshift($complaints, $newComplaint);
        saveComplaints($complaints);

        echo json_encode([
            'success' => true,
            'token' => $token,
            'complaint' => $newComplaint,
            'message' => 'તમારી ફરિયાદ સફળતાપૂર્વક નોંધાઈ ગઈ છે.'
        ]);
        break;

    case 'track_complaint':
        $token = trim($input['token'] ?? $input['query'] ?? ($_GET['token'] ?? ($_GET['query'] ?? '')));
        if (empty($token)) {
            echo json_encode(['success' => false, 'error' => 'ટોકન નંબર દાખલ કરો']);
            break;
        }

        $complaints = getComplaints();
        $found = null;
        foreach ($complaints as $c) {
            if (
                strcasecmp($c['token'], $token) === 0 || 
                (isset($c['id']) && strcasecmp($c['id'], $token) === 0) ||
                (!empty($c['citizen_mobile']) && $c['citizen_mobile'] === $token) ||
                (!empty($c['citizen_phone']) && $c['citizen_phone'] === $token)
            ) {
                $found = $c;
                break;
            }
        }

        if ($found) {
            echo json_encode(['success' => true, 'complaint' => $found]);
        } else {
            echo json_encode(['success' => false, 'error' => 'ટોકન નંબર "' . htmlspecialchars($token) . '" મળ્યો નથી. કૃપા કરીને સાચો ટોકન ચકાસો.']);
        }
        break;

    case 'get_all_complaints':
        $complaints = getComplaints();
        echo json_encode(['success' => true, 'complaints' => $complaints]);
        break;

    case 'update_status':
        $token = trim($input['token'] ?? $input['id'] ?? '');
        $newStatus = trim($input['status'] ?? '');
        $remarks = trim($input['remarks'] ?? $input['resolution_remarks'] ?? '');
        $resolved_photo_base64 = $input['resolved_photo_base64'] ?? $input['resolution_photo_base64'] ?? '';

        if (empty($token) || empty($newStatus)) {
            echo json_encode(['success' => false, 'error' => 'Missing token or status']);
            break;
        }

        $resolved_photo = null;
        if (!empty($resolved_photo_base64) && strpos($resolved_photo_base64, 'data:image') === 0) {
            $parts = explode(',', $resolved_photo_base64);
            if (isset($parts[1])) {
                $decoded = base64_decode($parts[1]);
                $filename = 'resolved_' . time() . '_' . rand(100, 999) . '.jpg';
                file_put_contents($uploadsDir . $filename, $decoded);
                $resolved_photo = 'storage/uploads/' . $filename;
            }
        }

        $complaints = getComplaints();
        $updated = false;
        foreach ($complaints as &$c) {
            if (
                strcasecmp($c['token'], $token) === 0 || 
                (isset($c['id']) && strcasecmp($c['id'], $token) === 0)
            ) {
                $c['status'] = $newStatus;
                if (!empty($remarks)) $c['resolution_remarks'] = $remarks;
                if ($newStatus === 'Resolved') {
                    $c['resolved_at'] = date('Y-m-d H:i:s');
                    if ($resolved_photo) {
                        $c['resolved_photo'] = $resolved_photo;
                        $c['resolution_photo'] = $resolved_photo;
                    }
                }
                $updated = true;
                break;
            }
        }

        if ($updated) {
            saveComplaints($complaints);
            echo json_encode(['success' => true, 'message' => 'સ્ટેટસ સફળતાપૂર્વક અપડેટ થયું']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Complaint not found']);
        }
        break;

    case 'rate_complaint':
        $token = trim($input['token'] ?? $input['id'] ?? '');
        $rating = intval($input['rating'] ?? 5);

        $complaints = getComplaints();
        $updated = false;
        foreach ($complaints as &$c) {
            if (
                strcasecmp($c['token'], $token) === 0 || 
                (isset($c['id']) && strcasecmp($c['id'], $token) === 0)
            ) {
                $c['rating'] = $rating;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            saveComplaints($complaints);
            echo json_encode(['success' => true, 'message' => 'તમારો અભિપ્રાય સબમિટ થયો. આભાર!']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Complaint not found']);
        }
        break;

    case 'debug_log':
        file_put_contents(__DIR__ . '/overflow_debug.json', json_encode($input, JSON_PRETTY_PRINT));
        echo json_encode(['ok' => true]);
        break;

    case 'login_admin':
        $username = trim($input['username'] ?? '');
        $password = trim($input['password'] ?? '');

        // Demo credentials
        if (($username === 'admin' && $password === 'amc2026') || ($username === 'officer' && $password === 'amc123')) {
            echo json_encode([
                'success' => true,
                'user' => [
                    'name' => 'રાજેશ વર્મા (Zonal Officer)',
                    'role' => 'Ward Inspector',
                    'zone' => 'West Zone & Ahmedabad Central',
                    'token' => 'auth_' . md5($username . time())
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'ખોટો આઈડી અથવા પાસવર્ડ']);
        }
        break;

    default:
        echo json_encode([
            'status' => 'online',
            'app' => 'AMC Seva Citizen Grievance Portal API',
            'version' => '2026.1',
            'city' => 'Ahmedabad Municipal Corporation'
        ]);
        break;
}
