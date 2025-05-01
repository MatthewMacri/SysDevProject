const express = require("express");
const bodyParser = require("body-parser");
const speakeasy = require("speakeasy");
const qrcode = require("qrcode");
const cors = require("cors");

const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

let userSecret = null; // In real apps, store this in a database per user

// 1. Generate TOTP Secret and QR Code
app.get("/2fa/setup", (req, res) => {
  const secret = speakeasy.generateSecret({
    name: "TexasGears",
    issuer: "TexasGears Inc.",
  });

  userSecret = secret.base32; // Store securely in real apps

  qrcode.toDataURL(secret.otpauth_url, (err, data_url) => {
    if (err) {
      return res.status(500).send("Failed to generate QR");
    }
    res.json({ qr: data_url, secret: secret.base32 });
  });
});

// 2. Verify TOTP Code
app.post("/2fa/verify", (req, res) => {
  const { token } = req.body;

  const verified = speakeasy.totp.verify({
    secret: userSecret,
    encoding: "base32",
    token,
    window: 1,
  });

  if (verified) {
    res.sendStatus(200); // Login success
  } else {
    res.status(401).send("Invalid token");
  }
});

app.listen(port, () => {
  console.log(`2FA backend running at http://localhost:${port}`);
});
