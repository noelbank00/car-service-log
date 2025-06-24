# Autószerviz Napló – Webprogramozói Feladat

## Feladat

Készíts alkalmazást PHP alapokon **Laravel keretrendszerben**, JavaScript (Vue.js, jQuery stb.), HTML, CSS, SQL (MySQL, MariaDB, SQLite) technológiák segítségével, amely egy autószerviz napló adatainak kezelésére szolgál.

---

## Irányelvek

- A vizuális megjelenés szabadon választható, de javasolt Bootstrap, Tailwind vagy hasonló CSS framework használata.
- PHP kód követi az **OOP** elveit. Több osztály használata (pl. service, action, request stb.).
- A PHP kód **ne tartalmazzon HTML-t**.
- A JavaScript és CSS kódok **legyenek elkülönítve**.
- Minden fájl legyen **UTF-8 kódolású**.

---

## Adatbázis Struktúra

Adatbázis neve: `carservice`

### Táblák:

#### `clients` – Ügyfelek

- `id` – egyedi azonosító
- `name` – név
- `card_number` – okmányazonosító (alfanumerikus)

#### `cars` – Autók

- `id`
- `client_id`
- `type`
- `registered`
- `ownbrand` – 1 = saját márkás, 0 = nem
- `accidents` – balesetek száma

#### `services` – Szerviznapló

- `id`
- `client_id`
- `car_id`
- `log_number` – szerviz alkalom (ügyfél + autó szerint egyedi)
- `event`
- `event_time`
- `document_id` – munkalap azonosítója

---

## Ősfeltöltés

Minden betöltéskor a kód ellenőrzi, hogy a táblák üresek-e. Ha igen, automatikusan töltsd fel az adatokat a csatolt JSON állományokból.

---

## Alkalmazás Funkcionalitás

### 1. Ügyfelek megjelenítése

Egy oldalas alkalmazás, ahol listázva vannak az ügyfelek:

- azonosító
- név
- okmányazonosító

### 2. Autók megjelenítése

Ügyfél nevére kattintva (AJAX segítségével, oldalfrissítés nélkül):

- `car_id`
- `type`
- `registered`
- `ownbrand`
- `accidents`
- utolsó szerviz esemény neve és időpontja

### 3. Szerviznapló megjelenítése

Autó sorszámára kattintva (szintén oldalfrissítés nélkül):

- `log_number`
- `event`
- `event_time`
- `document_id`

**Megjegyzés:** „regisztralt” esemény esetén `event_time` mező helyett a `registered` értéket jelenítsd meg.

---

## Kereső Funkció

Űrlap elemek:

- Ügyfél neve (`name`)
- Okmányazonosító (`card_number`)
- Gomb

### Validációk

- Legalább az egyik mező kötelező.
- Mindkét mező kitöltése hiba.
- `card_number` csak betűket és számokat tartalmazhat.
[proba_feladat_flexinform_uj.md](../../../../Users/noelbank/Downloads/proba_feladat_flexinform_uj.md)
### Keresés viselkedés

- Név esetén: részleges keresés, de több találat = hiba.
- Okmányazonosító: csak pontos találat elfogadott.

### Sikeres találat esetén megjelenítendő:

- Ügyfél azonosító
- Név
- Okmányazonosító
- Autóinak darabszáma
- Összes szerviznapló bejegyzés száma (összes autóra vonatkozóan)

---