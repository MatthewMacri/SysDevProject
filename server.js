import express from 'express';
import cors from 'cors';
import speakeasy from 'speakeasy';
import qrcode from 'qrcode';

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(express.json());

// Temporary in-memory store (replace with DB in production)
let currentSecret = null;

// Route to generate QR code and secret
app.get('/2fa/setup', (req, res) => {
  currentSecret = speakeasy.generateSecret({ name: 'Texas Gears App' });

  qrcode.toDataURL(currentSecret.otpauth_url, (err, data_url) => {
    if (err) {
      return res.status(500).json({ error: 'Failed to generate QR code' });
    }
    res.json({ qr: data_url, secret: currentSecret.base32 });
  });
});

// Route to verify 2FA code
app.post('/2fa/verify', (req, res) => {
  const { token } = req.body;

  const verified = speakeasy.totp.verify({
    secret: currentSecret?.base32,
    encoding: 'base32',
    token: token,
    window: 1, // allows slight clock drift
  });

  if (verified) {
    res.status(200).send('2FA Verified');
  } else {
    res.status(401).send('Invalid 2FA code');
  }
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});