# Razorpay Payment Integration Setup

## Prerequisites
- Razorpay Account (https://razorpay.com)
- CodeIgniter 4 Project

## Steps to Setup

### 1. Get Razorpay API Keys
1. Login to your Razorpay Dashboard: https://dashboard.razorpay.com
2. Go to Settings → API Keys
3. Copy your **Key ID** and **Key Secret**

### 2. Update Environment Variables
Add the following to your `.env` file:

```
RAZORPAY_KEY_ID=your_razorpay_key_id_here
RAZORPAY_KEY_SECRET=your_razorpay_key_secret_here
```

### 3. Run Database Migration
Run the migration to create the `song_requests` table:

```bash
php spark migrate
```

This will create the `song_requests` table with the following fields:
- id (Primary Key)
- name
- phone
- song_name
- singer_name
- screenshot (image path)
- razorpay_order_id
- razorpay_payment_id
- status (pending, approved, played, rejected)
- payment_status (pending, completed, failed)
- created_at
- updated_at

### 4. Routes Overview

| Method | Route | Description |
|--------|-------|-------------|
| GET | / | Song request form |
| POST | /submit | Submit form and create Razorpay order |
| POST | /payment-callback | Verify payment and update database |
| GET | /payment-success | Success page after payment |
| GET | /payment-failed | Failure page if payment fails |

### 5. Form Flow

1. User fills the song request form
2. User uploads screenshot (optional)
3. Form submitted to `/submit` endpoint
4. Server validates data and creates Razorpay order
5. Razorpay checkout modal opens
6. User completes payment
7. Payment verified and order updated
8. User redirected to success or failed page

### 6. Amount Configuration

The default amount is set to **₹500** (50000 paise). To change it:

**In Payment Controller (`app/Controllers/Payment.php`):**
Change the amount in the `submit()` method:
```php
$razorpayOrder = $this->createRazorpayOrder($requestId, 50000); // Amount in paise
```

**In Song Form View (`app/Views/song_form.php`):**
Change the amount in the Razorpay checkout options:
```javascript
let options = {
    "amount": 50000, // Amount in paise (₹500)
    ...
};
```

### 7. Database Field Details

- **status**: Current status of the request
  - pending: Initial status
  - approved: After payment verification
  - played: After DJ plays the song
  - rejected: If request is rejected

- **payment_status**: Payment status
  - pending: Initial status
  - completed: After successful payment
  - failed: If payment fails

### 8. Security Notes

- Always keep your Razorpay Key Secret secure
- Never commit `.env` file to version control
- Verify Razorpay signatures on the server-side
- Use HTTPS in production

### 9. Testing

**Razorpay Test Credentials:**
- Test Key ID and Secret are available in your Razorpay dashboard
- Use test cards like: 4111 1111 1111 1111 (Visa)
- Any future date for expiry and any CVV

### 10. Troubleshooting

**Payment modal not opening:**
- Check if Razorpay Key ID is correctly set
- Ensure Razorpay script is loaded

**Signature verification failing:**
- Verify that both Key ID and Key Secret are correct
- Check server time synchronization

**Database errors:**
- Ensure migration has been run: `php spark migrate`
- Check database connection in `.env`

For more details, visit: https://razorpay.com/docs/
