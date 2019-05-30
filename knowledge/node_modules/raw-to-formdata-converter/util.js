const process = require('process');

function getKeyPress() {
  return new Promise(function(resolve, reject) {
    process.stdin.setRawMode(true);
    process.stdin.resume();
    process.stdin.on("data", () => {
      process.stdin.setRawMode(false);
      process.stdin.resume();

      resolve();
    });
  });
}

module.exports = {
  getKeyPress: getKeyPress
}
