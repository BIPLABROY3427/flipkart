# AI Handoff Document: Product Scraping and Import Workflow

Hello Future AI Agent! 
This document contains the complete context, rules, and workflow for the automated product uploading system. Your task is to continue this process smoothly based on the user's instructions.

## Overview
The user manually downloads/updates product HTML pages from an e-commerce site and places them into a staging folder (`zz/`). Your job is to extract (scrape) data from these HTML files, format it into a specific JSON schema, and then run a PHP script to insert the data into the database.

## Directory Structure
- **Root Directory:** `/Applications/XAMPP/xamppfiles/htdocs/`
- **Staging Folder:** `zz/` (The user will place `product.html` and sometimes variant files like `ProductColor.html`, `ProductColor2.html`, etc., here).
- **JSON Schema File:** `product_schema.json` (Used as the intermediary data format).
- **PHP Import Script:** `admin/import_json.php` (Reads `product_schema.json` and imports it into the database).
- **Python Scraper:** Usually a script like `scrape.py` (located in the agent's scratchpad or a designated folder) that parses the HTML in `zz/` and updates `product_schema.json`.

## Crucial User Rules & Constraints
1. **NO NEWLINES IN TITLES (`\n`):** The user explicitly commanded: *"mana kaha tha ke '\n' yea upload nahe kerna"* (I told you not to upload `\n`). When extracting the product name (title), you **MUST** completely remove any newline characters (`\n`, `\r`) and extra spaces.
   - Example cleanup in Python: `name = name.replace('\n', ' ').strip()` or `re.sub(r'\s+', ' ', name).strip()`
2. **Handle Single & Multiple Variants:** Sometimes the user only updates `product.html` (single variant). Sometimes they include `ProductColor.html` (multiple variants). The scraper must check for the presence of these files and extract all available colors/variants.
3. **Database Insertion:** Always use the existing `admin/import_json.php` script to push the JSON data to the DB. Do not try to write custom SQL queries.

## Step-by-Step Workflow

When the user says something like *"ab yea Upload kerdoo"* or *"mana new product data add keya ha upload kerdoo"*:

### Step 1: Check the Staging Directory
- List the contents of `/Applications/XAMPP/xamppfiles/htdocs/zz/`.
- Identify if there is only `product.html` or if there are also variant files (like `ProductColor.html`).

### Step 2: Run the Scraper (Python)
- Run the Python script (e.g., `scrape.py`) to parse the HTML files in `zz/`.
- The scraper must:
  - Extract the product name (Remember: Clean out `\n`).
  - Extract MRP, Selling Price, Main Image, Gallery Images.
  - Extract Ratings (overall rating and star breakdown), Total Reviews.
  - Extract User Reviews (including reviewer name, location, time, rating, title, review text, and uploaded images).
  - Extract Color Variants (looping through all HTML files in `zz/` to get different color names and their respective gallery images).
- The scraper saves all this structured data into `/Applications/XAMPP/xamppfiles/htdocs/product_schema.json`.

### Step 3: Validate the JSON (Optional but Recommended)
- Quickly check `product_schema.json` to ensure the `"name"` field does not contain any `\n` and that the data looks correct.

### Step 4: Import to Database
- Run the PHP import script:
  `cd /Applications/XAMPP/xamppfiles/htdocs/ && /Applications/XAMPP/bin/php admin/import_json.php`
- Wait for the task to complete. It should output something like `Product inserted with ID: 101` and `Import Successful!`.

### Step 5: Inform the User
- Reply to the user in Hindi/Urdu (as they prefer) confirming the successful upload and providing the new Product ID. 
- Example: *"Aapka naya product successfully upload ho gaya hai, ID: 102."*

## Final Notes for the AI
Always stay vigilant about the text formatting (especially the newline rule). The user expects the process to be fully automated: they just drop the HTML files in the `zz` folder and ask you to upload, and you must seamlessly scrape -> JSON -> PHP Import. Good luck!
