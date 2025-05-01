import express from 'express';
import cors from 'cors';
import speakeasy from 'speakeasy';
import qrcode from 'qrcode';

const app = express();
app.use(cors());
app.use(express.json());

app.get('/2fa/setup', (req, res) => {
  const secret = speakeasy.generateSecret({ name: 'Texas Gears App' });

  qrcode.toDataURL(secret.otpauth_url, (err, data_url) => {
    if (err) {
      return res.status(500).json({ error: 'QR generation failed' });
    }
    res.json({ qr: data_url, secret: secret.base32 });
  });
});

app.post('/2fa/verify', (req, res) => {
  const { token, secret } = req.body;

  const verified = speakeasy.totp.verify({
    secret,
    encoding: 'base32',
    token,
  });

  if (verified) {
    res.status(200).send("2FA Verified");
  } else {
    res.status(401).send("Invalid code");
  }
});

app.listen(3000, () => {
  console.log("Server running on http://localhost:3000");
});