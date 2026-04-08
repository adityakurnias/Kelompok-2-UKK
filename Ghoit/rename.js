const fs = require('fs');
const path = require('path');

function walkDir(dir, callback) {
  fs.readdirSync(dir).forEach(f => {
    let dirPath = path.join(dir, f);
    let isDirectory = fs.statSync(dirPath).isDirectory();
    isDirectory ? walkDir(dirPath, callback) : callback(path.join(dir, f));
  });
}

walkDir('c:/Users/TOSHIBA/Downloads/Ahmad Q Ghoits - Aplikasi ATK/atk-ecommerce-main/resources/views', function(filePath) {
  if (filePath.endsWith('.blade.php')) {
    let content = fs.readFileSync(filePath, 'utf8');
    let orig = content;
    
    // ATKStore, ATKCheckout, ATKAdmin, ATKCart
    content = content.replace(/ATK<span class="text-blue-500">(Store|Checkout|Admin|Cart|Store Indonesia)<\/span>/gi, '<span class="rgb-glow-text">ATK Ghoits</span>');
    // ATK Store
    content = content.replace(/>Toko ATK</g, '>Toko ATK Ghoits<');
    content = content.replace(/- Toko ATK/g, '- Toko ATK Ghoits');
    content = content.replace(/ATK Store(?! Ghoits)( Indonesia)?/g, 'ATK Ghoits');
    
    if (content !== orig) {
        fs.writeFileSync(filePath, content);
        console.log('Updated ' + filePath);
    }
  }
});
