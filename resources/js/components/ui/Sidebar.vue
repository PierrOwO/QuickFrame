<template>
  <aside :class="{ open: open }">
    <div class="sidebar-header">
      <h2>Documentation</h2>
      <button class="close-btn" @click="$emit('close')">✕</button>
    </div>

    <nav>
      <!-- Getting Started -->
      <Accordion
        title="Getting Started"
        :model-value="openAccordion === 'Getting Started'"
        @update:modelValue="() => toggleAccordion('Getting Started')"
      >
        <a href="#getting-started" :class="{ active: activeSection === 'getting-started' }">Getting Started</a>
        <a href="#environment" :class="{ active: activeSection === 'environment' }">Environment</a>
      </Accordion>

      <!-- Views & Controllers -->
      <Accordion
        title="Views & Controllers"
        :model-value="openAccordion === 'Views & Controllers'"
        @update:modelValue="() => toggleAccordion('Views & Controllers')"
      >
        <a href="#views&layouts" :class="{ active: activeSection === 'views&layouts' }">Views & Layouts</a>
        <a href="#controllers" :class="{ active: activeSection === 'controllers' }">Controllers</a>
      </Accordion>

      <!-- Assets -->
      <Accordion
        title="CSS & JS"
        :model-value="openAccordion === 'CSS & JS'"
        @update:modelValue="() => toggleAccordion('CSS & JS')"
      >
        <a href="#css&js" :class="{ active: activeSection === 'css&js' }">CSS & JS</a>
      </Accordion>

      <!-- Auth & Sessions -->
      <Accordion
        title="Auth & Sessions"
        :model-value="openAccordion === 'Auth & Sessions'"
        @update:modelValue="() => toggleAccordion('Auth & Sessions')"
      >
        <a href="#auth&sessions" :class="{ active: activeSection === 'auth&sessions' }">Auth & Sessions</a>
        <a href="#session" :class="{ active: activeSection === 'session' }">Session</a>
        <a href="#cache" :class="{ active: activeSection === 'cache' }">Cache</a>
      </Accordion>

      <!-- Helpers & Libraries -->
      <Accordion
        title="Helpers & Libraries"
        :model-value="openAccordion === 'Helpers & Libraries'"
        @update:modelValue="() => toggleAccordion('Helpers & Libraries')"
      >
        <a href="#helpers" :class="{ active: activeSection === 'helpers' }">Helpers</a>
        <a href="#mail" :class="{ active: activeSection === 'mail' }">Mail</a>
        <a href="#pdf" :class="{ active: activeSection === 'pdf' }">PDF helper</a>
        <a href="#qrcode" :class="{ active: activeSection === 'qrcode' }">QR Code helper</a>
        <a href="#barcode" :class="{ active: activeSection === 'barcode' }">Barcode helper</a>
        <a href="#carbon" :class="{ active: activeSection === 'carbon' }">Carbon</a>
        <a href="#storage" :class="{ active: activeSection === 'storage' }">Storage</a>
        <a href="#upload" :class="{ active: activeSection === 'upload' }">Upload</a>
        <a href="#zip" :class="{ active: activeSection === 'zip' }">Zip</a>
      </Accordion>

      <!-- Database -->
      <Accordion
        title="Database"
        :model-value="openAccordion === 'Database'"
        @update:modelValue="() => toggleAccordion('Database')"
      >
        <a href="#migrations" :class="{ active: activeSection === 'migrations' }">Migrations</a>
        <a href="#seeders" :class="{ active: activeSection === 'seeders' }">Seeders</a>
      </Accordion>

      <!-- CLI -->
      <Accordion
        title="CLI"
        :model-value="openAccordion === 'CLI'"
        @update:modelValue="() => toggleAccordion('CLI')"
      >
        <a href="#cli" :class="{ active: activeSection === 'cli' }">CLI</a>
      </Accordion>

      <!-- Testing -->
      <Accordion
        title="Testing"
        :model-value="openAccordion === 'Testing'"
        @update:modelValue="() => toggleAccordion('Testing')"
      >
        <a href="#testing" :class="{ active: activeSection === 'testing' }">Testing</a>
      </Accordion>

      <!-- Config -->
      <Accordion
        title="Config"
        :model-value="openAccordion === 'Config'"
        @update:modelValue="() => toggleAccordion('Config')"
      >
        <a href="#config" :class="{ active: activeSection === 'config' }">Config</a>
      </Accordion>
    </nav>
  </aside>
</template>

<script setup>
import Accordion from './Accordion.vue';
import { ref } from 'vue';

const props = defineProps({
  open: Boolean,
  activeSection: String
});

const openAccordion = ref(null);

function toggleAccordion(title) {
  openAccordion.value = openAccordion.value === title ? null : title;
}
</script>

<style scoped>
aside {
  background: #007bff;
  color: white;
  padding: 1rem;
  height: 100vh;
  position: sticky;
  top: 0;
  overflow-y: auto;
  transition: left 0.3s ease;
}

.sidebar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.close-btn {
  display: none;
  background: none;
  border: none;
  font-size: 1.4rem;
  cursor: pointer;
  color: white;
}

/* Links */
nav a {
  display: block;
  padding: 0.4rem 0 0.4rem 0.8rem;
  color: white;
  text-decoration: none;
  opacity: 0.8;
}

nav a.active {
  font-weight: bold;
  opacity: 1;
}

/* MOBILE */
/* MOBILE: do szerokości 1000px */
@media (max-width: 1000px) {
  aside {
    position: fixed;
    left: -550px; /* lekko zmniejszone, aby nie wychodziło poza ekran */
    top: 0;
    width: 500px;
    height: 100vh;
    z-index: 1000;
    padding: 1.5rem; /* trochę więcej paddingu dla większych fontów */
    overflow-y: auto;
    transition: left 0.3s ease;
  }
  .sidebar-header h2{
    font-size: 2.5rem;
  }
  aside.open {
    left: 0;
  }

  .close-btn {
    display: inline-block;
    font-size: 2.5rem; /* większy przycisk zamykania */
  }

  nav {
    max-height: 80vh;       /* 80% wysokości widoku */
    overflow-y: auto;       /* przewijanie jeśli treść za długa */
    padding-right: 0.5rem;  /* scroll nie nachodzi na linki */
  }

  nav a {
    font-size: 2rem;      /* większa czcionka dla linków */
    padding: 1rem 0 1rem 1rem; /* większe paddingi dla lepszej czytelności */
  }

  
}
</style>