<!-- app/Views/user/register.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            color: #333;
        }

        input, select {
            width: calc(100% - 12px);
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 15px;
            color: #555;
        }

        a {
            color: #4caf50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        img{


            max-width: 30%;
            margin-left: auto;
        }
    </style>
</head>
<body>
<?php
// Display Bootstrap alert if it exists in session
$alert = session()->getFlashdata('alert');
if ($alert) {
    if (is_array($alert['message'])) {
        foreach ($alert['message'] as $error) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo esc($error);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
        }
    } else {
        echo '<div id="register-alert" class="alert alert-' . esc($alert['type']) . ' alert-dismissible fade show" role="alert">';
        echo esc($alert['message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}
?>
    <img src="assets/img/agilabanner.png" alt="">
    <h1>Hardware and Construction Supplies Register</h1>
    <form action="/register" method="post">
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required>
        <br>
        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="address">Address (Municipality, Barangay):</label>
        <select name="municipality" id="municipality" onchange="updateBarangays()" required>
            <option value="" selected disabled>Select Municipality</option>
            <option value="Bansud">Bansud</option>
            <option value="Baco">Baco</option>
            <option value="Bongabong">Bongabong</option>
            <option value="Bulalacao">Bulalacao</option>
            <option value="Calapan City">Calapan City</option>
            <option value="Gloria">Gloria</option>
            <option value="Mansalay">Mansalay</option>
            <option value="Naujan">Naujan</option>
            <option value="POla">Pola</option>
            <option value="Pinamalayan">Pinamalayan</option>
            <option value="Puerto Galera">Puerto Galera</option>
            <option value="Roxas">Roxas</option>
            <option value="San Teodoro">San Teodoro</option>
            <option value="Socorro">Socorro</option>
            <option value="Victoria">Victoria</option>
        </select>

        <select name="barangay" id="barangay" required>
            <option value="" selected disabled>Select Barangay</option>
        </select>
        <br>
        <label for="sitio" style="text-align: center">Sitio:</label>
        <input type="text" id="sitio" name="sitio" style="width:60%;" required />
        <br>
        <label for="phone">Phone:</label>
        <input type="number" id="inputText" name="phone" minlength="11" maxlength="11" placeholder="ex. 09123456789" required />
        <br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="/login">Login here</a></p>


<!-- // <input id="inputText"
//        type="number"
//        minLength="11"
//        maxLength="11"
//        onKeyDown={e=>this.checkLength(e)} />

//        checkLength(e){
//         if(e.target.value.length ===
//         e.target.maxLength){
//             e.stopPropagation();
//             e.preventDefault();
//             return false;
//         }
//         return true;
//        } -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<!-- Check if $alertMessage is set before displaying the alert -->
<?php if (isset($alertMessage)): ?>
    <script>
        // Display custom alert message
        var alertMessage = "<?php echo $alertMessage; ?>";
        if (alertMessage) {
            alert(alertMessage);
        }
    </script>
<?php endif; ?>
</body>
<script>
    // Auto-hide the alert after 3 seconds
    setTimeout(function() {
        document.getElementById('register-alert').style.display = 'none';
    }, 3000);


    function updateBarangays() {
        var municipality = document.getElementById('municipality').value;
        var barangayDropdown = document.getElementById('barangay');
        barangayDropdown.innerHTML = '<option value="" selected disabled>Select Barangay</option>';

        switch (municipality) {
            case 'Bansud':
                populateBarangays(['Alcadesma', 'Bato', 'Conrazon', 'Malo', 'Manihala', 'Pag-asa', 'Poblacion', 'Proper Bansud', 'Rosacara', 'Salcedo', 'Sumaguiw', 'Proper Tiguisan', 'Villa Pag-Asa']);
                break;
            case 'Baco':
                populateBarangays(['Alag', 'Bangkatan', 'Baras (Mangyan Minority)', 'Bayanan', 'Burbuli', 'Catwiran I', 'Catwiran II', 'Dulangan I', 'Dulangan II', 'Lantuyang (Mangyan Minority)', 'Lumang Bayan', 'Malapad', 'Mangangan I', 'Mangangan II', 'Mayabig', 'Pambisan', 'Poblacion', 'Pulang-Tubig', 'Putican-Cabulo', 'San Andres', 'San Ignacio (Dulangan)', 'Santa Cruz', 'Santa Rosa I', 'Santa Rosa II', 'Tabon-tabon', 'Tagumpay', 'Water']);
                break;
            case 'Bongabong':
                populateBarangays(['Anilao', 'Aplaya', 'Bagumbayan I', 'Bagumbayan II', 'Batangan', 'Camantigue', 'Bukal', 'Carmundo', 'Cawayan', 'Dayhagan', 'Formon', 'Hagan', 'Hagupit', 'Ipil', 'Kaligtasan', 'Labasan', 'Labonan', 'Libertad', 'Lisap', 'Luna', 'Malitbog', 'Mapang', 'Masaguisi', 'Mina de Oro', 'Morente', 'Ogbot', 'Orconuma', 'Poblacion', 'Pulosahi', 'Sagana', 'San Isidro', 'San Jose', 'San Juan', 'Santa Cruz', 'Sigange', 'Tawas']);
                break;
            case 'Bulalacao':
                populateBarangays(['Bagong Sikat', 'Balatasan', 'Benli (Mangyan Settlement)', 'Cabugao', 'Cambunang (Poblacion)', 'Campaasan (Poblacion)', 'Maasin', 'Maujao', 'Milagrosa (Guiob)', 'Nasukob (Poblacion)', 'Poblacion', 'San Francisco (Alimawan)', 'San Isidro', 'San Juan', 'San Roque (Buyayao)']);
                break;
            case 'Calapan City':
                populateBarangays(['Balingayan', 'Balite', 'Baruyan', 'Batino', 'Bayanan I', 'Bayanan II', 'Biga', 'Bondoc', 'Bucayao', 'Buhuan', 'Bulusan', 'Calero', 'Camansihan', 'Camilmil', 'Canubing I', 'Canubing II', 'Comunal', 'Guinobatan', 'Gulod', 'Gutad', 'Ibaba East', 'Ibaba West', 'Ilaya', 'Lalud', 'Lazareto', 'Libis', 'Lumangbayan', 'Mahal Na Pangalan', 'Maidlang', 'Malad', 'Malamig', 'Managpi', 'Masipit', 'Nag-Iba I', 'Nag-Iba II', 'Navotas', 'Pachoca', 'Palhi', 'Panggalaan', 'Parang', 'Patas', 'Personas', 'Puting Tubig', 'San Antonio', 'San Raphael (formerly Salong)', 'San Vicente Central', 'San Vicente East', 'San Vicente North', 'San Vicente South', 'San Vicente West', 'Sapul', 'Silonay', 'Sta. Cruz', 'Sta. Isabel', 'Sta. Maria Village', 'Sta. Rita', 'Sto. Niño (formerly Nacoco)', 'Suqui', 'Tawagan', 'Tawiran', 'Tibag', 'Wawa']);
                break;
            case 'Gloria':
                populateBarangays(['Agsalin', 'Agos', 'Alma Villa', 'Andres Bonifacio', 'Balete', 'Banus', 'Banutan', 'Buong Lupa', 'Bulaklakan', 'Gaudencio Antonino', 'Guimbonan', 'Kawit',' Lucio Laurel', 'Macario Adriatico', 'Malamig', 'Malayong', 'Maligaya (Poblacion)', 'Malubay', 'Manguyang', 'Maragooc', 'Mirayan', 'Narra', 'Papandungin', 'San Antonio', 'Santa Maria', 'Santa Theresa', 'Tambong']);
                break;
            case 'Mansalay':
                populateBarangays(['B. Del Mundo', 'Balugo', 'Bonbon', 'Budburan', 'Cabalwa', 'Don Pedro', 'Maliwanag', 'Manaul', 'Panaytayan', 'Poblacion', 'Roma', 'Santa Maria', 'Santa Teresita', 'Sta. Brigida', 'Villa Celestial', 'Wasig', 'Waygan']);
                break;
            case 'Naujan':
                populateBarangays(['Adrialuna', 'Andres Ylagan (Mag-asawang Tubig)', 'Antipolo', 'Apitong', 'Arangin', 'Aurora', 'Bacungan', 'Bagong Buhay', 'Balite', 'Bancuro', 'Banuton', 'Barcenaga', 'Bayani', 'Buhangin', 'Caburo', 'Concepcion', 'Dao', 'Del Pilar', 'Estrella', 'Evangelista', 'Gamao', 'General Esco', 'Herrera', 'Inarawan', 'Kalinisan', 'Laguna', 'Mabini', 'Magtibay', 'Mahabang Parang', 'Malabo', 'Malaya', 'Malinao', 'Malvar', 'Masagana', 'Masaguing', 'Melgar A', 'Melgar B', 'Metolza', 'Montelago', 'Montemayor', 'Motoderazo', 'Mulawin', 'Nag-Iba I', 'Nag-Iba II', 'Pagkakaisa', 'Paitan', 'Paniquian', 'Pinagsabangan I', 'Pinagsabangan II', 'Pinahan', 'Poblacion I (Barangay I)', 'Poblacion II (Barangay II)', 'Poblacion III (Barangay III)', 'Sampaguita', 'San Agustin I', 'San Agustin II', 'San Andres', 'San Antonio', 'San Carlos', 'San Isidro', 'San Jose', 'San Luis', 'San Nicolas', 'San Pedro', 'Santa Cruz', 'Santa Isabel', 'Santa Maria', 'Santiago', 'Santo Nino', 'Tagumpay', 'Tigkan']);
                break;
            case 'Pola':
                populateBarangays(['Bacauan', 'Bacungan', 'Batuhan', 'Bayanan', 'Biga', 'Buhay na Tubig', 'Calubasanhon', 'Calima', 'Casiligan', 'Malibago', 'Maluanluan', 'Matulatula', 'Pahilahan', 'Panikihan', 'Zone I (Poblacion)', 'Zone II (Poblacion)', 'Pula', 'Puting Cacao', 'Tagbakin', 'Tagumpay', 'Tiguihan', 'Campamento', 'Misong']);
                break;
            case 'Pinamalayan':
                populateBarangays(['Anoling', 'Bacungan', 'Bangbang', 'Banilad', 'Buli', 'Cacawan', 'Calingag', 'Delrazon', 'Guinhawa', 'Inclanay', 'Lumambayan', 'Malaya', 'Maliancog', 'Maningcol', 'Marayos', 'Marfrancisco', 'Nabuslot', 'Pagalagala', 'Palayan', 'Pambisan Malaki', 'Pambisan Munti', 'Panggulayan', 'Papandayan', 'Pili', 'Quinabigan', 'Ranzo', 'Rosario', 'Sabang', 'Sta. Isabel', 'Sta. Maria', 'Sta. Rita', 'Sto. Nino', 'Wawa', 'Zone I', 'Zone II', 'Zone III', 'Zone IV']);
                break;
            case 'Puerto Galera':
                populateBarangays(['Aninuan', 'Baclayan', 'Balater', 'Dulangan', 'Palangan', 'Poblacion', 'Sabang', 'San Antonio', 'San Isidro', 'Santo Niño', 'Sinandigan', 'Tabinay', 'Villaflor']);
                break;
            case 'Roxas':
                populateBarangays(['Bagumbayan (Poblacion)', 'Cantil', 'Dangay', 'Happy Valley', 'Libertad', 'Libtong', 'Little Tanauan', 'Mabuhay', 'Maraska', 'Odiong', 'Paclasan (Poblacion)', 'San Aquilino', 'San Isidro', 'San Jose', 'San Mariano', 'San Miguel', 'San Rafael', 'San Vicente', 'Uyao', 'Victoria']);
                break;
            case 'San Teodoro':
                populateBarangays(['Bigaan', 'Calangatan', 'Calsapa', 'Caugatayan', 'Ilag', 'Lumangbayan', 'Poblacion', 'Tacligan']);
                break;
            case 'Socorro':
                populateBarangays(['Batong Dalig', 'Bayuin', 'Bugtong Na Tuog', 'Calocmoy', 'Calubayan', 'Catiningan', 'Epiz (Bagsok)', 'Happy Valley', 'La Fortuna (Putol)', 'Leuteboro I', 'Leuteboro II', 'Mabuhay I', 'Mabuhay II', 'Malugay', 'Maria Concepcion', 'Matungao', 'Monteverde', 'Pasi I', 'Pasi II', 'Santo Domingo (Lapog)', 'Subaan', 'Villareal (Daan)', 'Zone I (Pob.)', 'Zone II (Pob.)', 'Zone III (Pob.)', 'Zone IV (Pob.)']);
                break;
            case 'Victoria':
                populateBarangays(['Alcate', 'Antonino (Mainao)', 'Babangonan', 'Bagong Buhay', 'Bagong Silang', 'Bambanin', 'Bethel', 'Canaan', 'Concepcion', 'Duongan', 'Leido', 'Loyal', 'Mabini', 'Macatoc', 'Malabo', 'Merit', 'Ordovilla', 'Pakyas', 'Poblacion I', 'Poblacion II', 'Poblacion III', 'Poblacion IV', 'Sampaguita', 'San Antonio', 'San Cristobal', 'San Gabriel', 'San Gelacio', 'San Isidro', 'San Juan', 'San Narciso', 'Urdaneta', 'Villa Cerveza']);
                break;
            // Add cases for other municipalities here
            default:
                break;
        }
    }

    function populateBarangays(barangays) {
        var barangayDropdown = document.getElementById('barangay');
        barangays.forEach(function(barangay) {
            var option = document.createElement('option');
            option.value = barangay;
            option.textContent = barangay;
            barangayDropdown.appendChild(option);
        });
    }
</script>

</html>

