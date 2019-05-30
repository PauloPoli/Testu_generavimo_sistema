#!/usr/bin/env node

const clipboardy = require('clipboardy');
const process = require('process');
const util = require('./util');

async function main() {
  console.log("Please copy the data you need to convert");
  await util.getKeyPress();

  const data = clipboardy.readSync();
  clipboardy.writeSync(convert(data));
  console.log("Encoded data is copied into the clipboard");

  process.exit(0);
}

main();

function convert(data) {
  return data.split("&").map(argument => {
    let parts = argument.split("=", 2).map(p => p.trim())
    let key = parts[0];
    let value = decodeURIComponent(parts[1]);
    return `${key}: ${value}`;
  }).join("\n");
}
