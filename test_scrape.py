import sys
sys.path.append('/Users/biplab/.gemini/antigravity-ide/brain/bed9beb3-5566-4028-a357-f5c8f0613d2b/scratch')
from scrape import scrape_file
print(scrape_file('/Applications/XAMPP/xamppfiles/htdocs/zz/product.html')["attributes"]["color"])
print(scrape_file('/Applications/XAMPP/xamppfiles/htdocs/zz/ProductColor.html')["attributes"]["color"])
