<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>GK'S Clinic - Hospital Management</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
/* trimmed CSS from previous cleaned version — keep this file as before */
body{font-family:Arial,Helvetica,sans-serif;background:#f4f4f4;margin:0;padding:0}
.container{max-width:960px;margin:28px auto;background:#f82b2b;padding:18px;border-radius:8px;color:#fff}
header.navbar{display:flex;align-items:center;justify-content:space-between;background:#2e7d32;padding:10px;border-radius:6px}
.logo img{height:56px;border-radius:6px}
.hidden{display:none}
input,select,textarea,button{display:block;width:100%;padding:8px;margin:8px 0;border-radius:6px;border:1px solid #ccc}
button{background:#2e7d32;color:#fff;border:none;cursor:pointer}
table{width:100%;border-collapse:collapse;margin-top:12px;background:#fff}
th,td{padding:8px;border:1px solid #ddd;color:#000}
.doctor-present{color:green;font-weight:700}
.doctor-absent{color:red;font-weight:700}
.success{color:green}
.alert{color:#b71c1c}
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:10px}
@media(max-width:720px){.two-col{grid-template-columns:1fr}}
</style>
</head>
<body>
<marquee>🏥 Hospital Management System — your health is your wealth 🩺</marquee>

<div class="container" id="auth-container">
  <header class="navbar">
    <div style="display:flex;gap:12px;align-items:center">
      <div class="logo"><img src="images/cardback.jpeg" alt="Logo" onerror="this.src='https://via.placeholder.com/120x56.png?text=GK+Clinic'"></div>
      <div><strong>GK'S CLINIC</strong></div>
    </div>
    <nav>
      <a href="#" onclick="showSection('about-section')">About</a> |
      <a href="#" onclick="showSection('services-section')">Services</a>
    </nav>
  </header>

  <section id="about-section" class="hidden">
    <h2>About Us</h2>
    <p>GK's Clinic (Atlist Medica) — contact: 0756651581 / 0718219840</p>
  </section>

  <section id="services-section" class="hidden">
    <h2>Services</h2>
    <ul>
      <li>Consultation</li><li>Pharmacy</li><li>Records</li><li>Reminders</li>
    </ul>
  </section>

  <div id="login-form">
    <h3>Login</h3>
    <input id="login-username" placeholder="Username">
    <input id="login-password" type="password" placeholder="Password">
    <button onclick="login()">Login</button>
    <p>Don't have account? <a href="#" onclick="toggleAuth()">Register</a></p>
    <p id="login-error" class="alert"></p>
  </div>

  <div id="register-form" class="hidden">
    <h3>Register</h3>
    <input id="reg-username" placeholder="Username">
    <input id="reg-password" type="password" placeholder="Password">
    <input id="reg-email" placeholder="Email">
    <input id="reg-phone" placeholder="Phone (optional)">
    <button onclick="register()">Create account</button>
    <p>Already have an account? <a href="#" onclick="toggleAuth()">Login</a></p>
    <p id="register-error" class="alert"></p>
  </div>

  <footer>&copy; 2025 GK'S Clinic</footer>
</div>

<div class="container hidden" id="dashboard">
  <div style="display:flex;justify-content:space-between;align-items:center">
    <h2>Dashboard</h2>
    <div><button onclick="logout()">Logout</button></div>
  </div>

  <div class="two-col">
    <div style="background:#fff;padding:12px;border-radius:8px;color:#000">
      <h3>Register Patient</h3>
      <input id="patient-name" placeholder="Full name">
      <input id="patient-age" type="number" placeholder="Age">
      <select id="patient-gender"><option value="">Gender</option><option value="M">Male</option><option value="F">Female</option><option value="O">Other</option></select>
      <textarea id="patient-illness" placeholder="Illness"></textarea>
      <input id="patient-date" type="date">
      <input id="patient-time" type="time">
      <button onclick="registerPatient()">Register Patient</button>
      <p id="patient-message" class="success"></p>

      <h4>Search Patients</h4>
      <input id="patient-search" placeholder="Search">
      <button onclick="searchPatients()">Search</button>
      <ul id="patient-results"></ul>

      <h4>All Patients</h4>
      <table><thead><tr><th>Name</th><th>Age</th><th>Gender</th><th>Illness</th><th>Appointment</th><th>Action</th></tr></thead>
      <tbody id="patient-table"></tbody></table>
    </div>

    <div style="background:#fff;padding:12px;border-radius:8px;color:#000">
      <h3>Store Inventory</h3>
      <table><thead><tr><th>Medicine</th><th>Expiry</th><th>Qty</th><th>Status</th></tr></thead><tbody id="medicine-table"></tbody></table>
      <div id="store-alerts" class="alert"></div>

      <h4>Add / Update Medicine</h4>
      <input id="med-name" placeholder="Medicine">
      <input id="med-expiry" type="date">
      <input id="med-quantity" type="number" placeholder="Quantity">
      <button onclick="addMedicine()">Add / Update</button>
      <p id="med-message" class="success"></p>

      <hr>
      <h3>Doctors</h3>
      <input id="search-illness" placeholder="Search by illness or specialty" oninput="filterDoctors()">
      <table><thead><tr><th>Name</th><th>Specialty</th><th>Available</th><th>Days/Edit</th></tr></thead><tbody id="doctor-table"></tbody></table>
      <h4>Add Doctor</h4>
      <input id="doc-name" placeholder="Doctor name">
      <input id="doc-specialty" placeholder="Specialty">
      <input id="doc-illness" placeholder="Illness treated">
      <div style="display:flex;flex-wrap:wrap;gap:6px;margin:6px 0">
        <label><input class="doc-day" type="checkbox" value="Monday">Mon</label>
        <label><input class="doc-day" type="checkbox" value="Tuesday">Tue</label>
        <label><input class="doc-day" type="checkbox" value="Wednesday">Wed</label>
        <label><input class="doc-day" type="checkbox" value="Thursday">Thu</label>
        <label><input class="doc-day" type="checkbox" value="Friday">Fri</label>
        <label><input class="doc-day" type="checkbox" value="Saturday">Sat</label>
        <label><input class="doc-day" type="checkbox" value="Sunday">Sun</label>
      </div>
      <button onclick="submitDoctor()">Save Doctor</button>
      <p id="doc-message" class="success"></p>
    </div>
  </div>

  <p id="reminder-message" class="alert"></p>
</div>

<script>
const API_BASE = ''; // same folder, adjust if needed

function showSection(id){
  document.getElementById('about-section').classList.add('hidden');
  document.getElementById('services-section').classList.add('hidden');
  if(id) document.getElementById(id).classList.remove('hidden');
}

function toggleAuth(){
  document.getElementById('login-form').classList.toggle('hidden');
  document.getElementById('register-form').classList.toggle('hidden');
  document.getElementById('login-error').innerText='';
  document.getElementById('register-error').innerText='';
}

/* AUTH */
async function login(){
  const username = document.getElementById('login-username').value.trim();
  const password = document.getElementById('login-password').value;
  if(!username||!password){ document.getElementById('login-error').innerText='Enter credentials.'; return; }
  const fd = new FormData(); fd.append('action','login'); fd.append('username',username); fd.append('password',password);
  const res = await fetch(API_BASE + 'auth.php', { method:'POST', body:fd });
  const j = await res.json();
  if(j.status === 'success'){ openDashboard(); } else { document.getElementById('login-error').innerText = j.message || 'Login failed'; }
}

async function register(){
  const username = document.getElementById('reg-username').value.trim();
  const password = document.getElementById('reg-password').value;
  const email = document.getElementById('reg-email').value.trim();
  const phone = document.getElementById('reg-phone').value.trim();
  const fd = new FormData(); fd.append('action','register'); fd.append('username',username); fd.append('password',password); fd.append('email',email); fd.append('phone',phone);
  const res = await fetch(API_BASE + 'auth.php', { method:'POST', body:fd });
  const j = await res.json();
  if(j.status === 'success'){ alert('Registered. Login.'); toggleAuth(); } else { document.getElementById('register-error').innerText = j.message || 'Error'; }
}

async function logout(){
  const fd = new FormData(); fd.append('action','logout');
  await fetch(API_BASE + 'auth.php',{method:'POST',body:fd});
  document.getElementById('dashboard').classList.add('hidden');
  document.getElementById('auth-container').classList.remove('hidden');
}

/* Dashboard flow */
function openDashboard(){
  document.getElementById('auth-container').classList.add('hidden');
  document.getElementById('dashboard').classList.remove('hidden');
  renderAll();
}

/* Patients */
async function registerPatient(){
  const name = document.getElementById('patient-name').value.trim();
  const age = document.getElementById('patient-age').value;
  const gender = document.getElementById('patient-gender').value;
  const illness = document.getElementById('patient-illness').value.trim();
  const date = document.getElementById('patient-date').value;
  const time = document.getElementById('patient-time').value;
  if(!name||!age||!gender||!date||!time){ document.getElementById('patient-message').innerText='Fill all fields'; return; }
  const fd = new FormData(); fd.append('action','add'); fd.append('name',name); fd.append('age',age); fd.append('gender',gender); fd.append('illness',illness); fd.append('date',date); fd.append('time',time);
  const res = await fetch(API_BASE + 'patients.php', { method:'POST', body:fd });
  const j = await res.json();
  if(j.status === 'success'){
    document.getElementById('patient-message').innerText = `Patient ${name} registered.`;
    document.getElementById('patient-name').value=''; document.getElementById('patient-age').value=''; document.getElementById('patient-gender').value=''; document.getElementById('patient-illness').value=''; document.getElementById('patient-date').value=''; document.getElementById('patient-time').value='';
    renderPatients();
    // on-screen reminder demo after 5s
    setTimeout(()=>{ document.getElementById('reminder-message').innerText = `🔔 Reminder: ${name} appointment on ${date} ${time}`; }, 5000);
  } else {
    document.getElementById('patient-message').innerText = j.message || 'Error';
  }
}

async function renderPatients(){
  const res = await fetch(API_BASE + 'patients.php?action=list');
  const j = await res.json();
  const tbody = document.getElementById('patient-table');
  tbody.innerHTML = '';
  if(j.status !== 'success' || !j.data.length){ tbody.innerHTML = '<tr><td colspan="6" style="text-align:center">No patients</td></tr>'; return; }
  j.data.forEach(p => {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${p.name}</td><td>${p.age}</td><td>${p.gender}</td><td>${p.illness||''}</td><td>${p.appointment||''}</td><td><button onclick="deletePatient(${p.id})">Delete</button></td>`;
    tbody.appendChild(tr);
  });
}

async function deletePatient(id){
  if(!confirm('Delete patient?')) return;
  const fd = new FormData(); fd.append('action','delete'); fd.append('id',id);
  const res = await fetch(API_BASE + 'patients.php',{method:'POST',body:fd});
  const j = await res.json();
  if(j.status === 'success') renderPatients(); else alert(j.message||'Error');
}

async function searchPatients(){
  const q = document.getElementById('patient-search').value.trim().toLowerCase();
  const res = await fetch(API_BASE + 'patients.php?action=list');
  const j = await res.json();
  const ul = document.getElementById('patient-results'); ul.innerHTML='';
  if(j.status !== 'success') return;
  const filtered = j.data.filter(p => p.name.toLowerCase().includes(q) || (p.illness||'').toLowerCase().includes(q));
  if(filtered.length === 0) { ul.innerHTML = '<li>No patients found</li>'; return; }
  filtered.forEach(p => { const li = document.createElement('li'); li.innerText = `${p.name} — ${p.illness} — ${p.appointment}`; ul.appendChild(li); });
}

/* Medicines */
async function addMedicine(){
  const name = document.getElementById('med-name').value.trim();
  const expiry = document.getElementById('med-expiry').value;
  const quantity = document.getElementById('med-quantity').value;
  if(!name||!expiry||quantity===''){ document.getElementById('med-message').innerText='Fill all fields'; return; }
  const fd = new FormData(); fd.append('action','add'); fd.append('name',name); fd.append('expiry',expiry); fd.append('quantity',quantity);
  const res = await fetch(API_BASE + 'medicines.php',{method:'POST',body:fd});
  const j = await res.json();
  if(j.status === 'success') { document.getElementById('med-message').innerText = `Saved ${name}`; document.getElementById('med-name').value=''; document.getElementById('med-expiry').value=''; document.getElementById('med-quantity').value=''; renderMedicines(); }
  else document.getElementById('med-message').innerText = j.message || 'Error';
}

async function renderMedicines(){
  const res = await fetch(API_BASE + 'medicines.php?action=list');
  const j = await res.json();
  const tbody = document.getElementById('medicine-table');
  const alerts = document.getElementById('store-alerts'); alerts.innerText='';
  tbody.innerHTML = '';
  if(j.status !== 'success' || !j.data.length){ tbody.innerHTML = '<tr><td colspan="4" style="text-align:center">No medicines</td></tr>'; return; }
  const today = new Date();
  j.data.forEach(m => {
    const exp = new Date(m.expiry);
    const diffDays = Math.ceil((exp - today)/(1000*60*60*24));
    let status = 'OK';
    if(diffDays <= 30) status = 'Expiring soon';
    if(m.quantity < 10) status += ' | Low stock';
    tbody.innerHTML += `<tr><td>${m.name}</td><td>${m.expiry}</td><td>${m.quantity}</td><td>${status}</td></tr>`;
    if(diffDays <= 30) alerts.innerText += `${m.name} expiring in ${diffDays} day(s)\n`;
    if(m.quantity < 10) alerts.innerText += `${m.name} low stock (${m.quantity})\n`;
  });
}

/* Doctors */
async function submitDoctor(){
  const name = document.getElementById('doc-name').value.trim();
  const specialty = document.getElementById('doc-specialty').value.trim();
  const illness = document.getElementById('doc-illness').value.trim();
  const days = Array.from(document.querySelectorAll('.doc-day:checked')).map(cb=>cb.value).join(',');
  if(!name||!specialty||!days){ document.getElementById('doc-message').innerText='Fill required'; return; }
  const fd = new FormData(); fd.append('action','add'); fd.append('name',name); fd.append('specialty',specialty); fd.append('illness',illness); fd.append('days',days);
  const res = await fetch(API_BASE + 'doctors.php',{method:'POST',body:fd});
  const j = await res.json();
  if(j.status === 'success'){ document.getElementById('doc-message').innerText = `Saved ${name}`; document.getElementById('doc-name').value=''; document.getElementById('doc-specialty').value=''; document.getElementById('doc-illness').value=''; document.querySelectorAll('.doc-day').forEach(cb=>cb.checked=false); renderDoctors(); } else document.getElementById('doc-message').innerText = j.message || 'Error';
}

async function renderDoctors(){
  const res = await fetch(API_BASE + 'doctors.php?action=list');
  const j = await res.json();
  const table = document.getElementById('doctor-table'); table.innerHTML='';
  if(j.status !== 'success' || !j.data.length){ table.innerHTML = '<tr><td colspan="4" style="text-align:center">No doctors</td></tr>'; return; }
  const weekday = new Date().toLocaleDateString('en-US',{weekday:'long'});
  j.data.forEach((d,i) => {
    const isPresent = (d.days||'').split(',').includes(weekday);
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${d.name}</td><td>${d.specialty}</td><td class="${isPresent?'doctor-present':'doctor-absent'}">${isPresent?'Present Today':'Absent Today'}</td><td>${d.days} <br></td>`;
    table.appendChild(tr);
  });
}

async function filterDoctors(){
  const q = document.getElementById('search-illness').value.trim().toLowerCase();
  const res = await fetch(API_BASE + 'doctors.php?action=list');
  const j = await res.json();
  const table = document.getElementById('doctor-table'); table.innerHTML = '';
  if(j.status !== 'success') return;
  const weekday = new Date().toLocaleDateString('en-US',{weekday:'long'});
  const filtered = j.data.filter(d => d.name.toLowerCase().includes(q) || (d.specialty||'').toLowerCase().includes(q) || (d.illness||'').toLowerCase().includes(q));
  if(!filtered.length){ table.innerHTML = '<tr><td colspan="4" style="text-align:center">No doctors</td></tr>'; return; }
  filtered.forEach(d => {
    const isPresent = (d.days||'').split(',').includes(weekday);
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${d.name}</td><td>${d.specialty}</td><td class="${isPresent?'doctor-present':'doctor-absent'}">${isPresent?'Present Today':'Absent Today'}</td><td>${d.days}</td>`;
    table.appendChild(tr);
  });
}

/* Render all */
function renderAll(){ renderPatients(); renderMedicines(); renderDoctors(); }

/* On load: if session exists (PHP keeps session), we can't detect directly from JS.
   Simpler: after login, backend sets session and we opened dashboard manually.
   You may implement an endpoint to check session if needed. */

</script>
</body>
</html>
