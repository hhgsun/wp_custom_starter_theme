// Require modules.
var DirArchiver = require('dir-archiver');

const fs = require('fs')

const slugify = (text) => {
  var charMap = {
    'çÇ': 'c',
    'ğĞ': 'g',
    'şŞ': 's',
    'üÜ': 'u',
    'ıİ': 'i',
    'öÖ': 'o'
  };
  for (var key in charMap) {
    text = text.replace(new RegExp('[' + key + ']', 'g'), charMap[key]);
  }
  return text.replace(/[^-a-zA-Z0-9\s]+/ig, '') // remove non-alphanumeric chars
    .replace(/\s/gi, "_") // convert spaces to dashes
    .replace(/[-]+/gi, "_") // trim repeated dashes
    .toLowerCase();
}

var themeName = '';

try {
  // GET THEME NAME FROM STYLE.css

  const data = fs.readFileSync('style.css', 'utf8')

  var lines = data.split('\n');

  var themeLine = lines[1];

  themeName = themeLine.split(':')[1];

  themeName = slugify(themeName.trim());

} catch (err) {
  themeName = 'hhgsun_new_theme';
  console.error(err);
}


// Create an array with the files and directories to exclude.
const excludes = [
  'generate.js',
  'directory_name', 'file.extension', '.DS_Store', '.stylelintrc.json', '.eslintrc',
  '.git', '.gitattributes', '.github', '.gitignore', 'README.md', 'composer.json', 'composer.lock',
  'node_modules', 'vendor', 'package-lock.json', 'package.json', '.travis.yml', 'phpcs.xml.dist', 'sass', 'style.css.map'
];

/**
 * Create a dir-archiver object. 
 * @param {string} directoryPath - The path of the folder to archive.
 * @param {string} zipPath - The path of the zip file to create.
 * @param {array} excludes - A list with the names of the files and folders to exclude.
*/
var archive = new DirArchiver('.', `../${themeName}.zip`, excludes);

// Create the zip file.
archive.createZip();