<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pagar con Stripe</title>
  <script src="https://js.stripe.com/v3/"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">💳 Pagar con Stripe</h2>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-1" for="name">Nombre del cliente</label>
      <input id="name" type="text" value="Juan Pérez"
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-1" for="email">Correo del cliente</label>
      <input id="email" type="email" value="cliente@ejemplo.com"
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-1" for="amount">Monto (MXN)</label>
      <input id="amount" type="number" value="250"
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
    </div>

    <div id="card-element" class="p-3 border border-gray-300 rounded-md mb-4"></div>

    <button id="payButton"
      class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-md transition-all">
      Pagar ahora
    </button>

    <div id="card-errors" class="text-red-600 mt-3 text-sm text-center"></div>
    <div id="success-message" class="text-green-600 mt-3 text-center font-medium hidden">
      ✅ ¡Pago realizado correctamente!
    </div>
  </div>

  <script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const payButton = document.getElementById('payButton');
    const cardErrors = document.getElementById('card-errors');
    const successMsg = document.getElementById('success-message');

    const elements = stripe.elements();
    const cardElement = elements.create('card', {
      style: {
        base: {
          iconColor: '#4f46e5',
          color: '#1f2937',
          fontWeight: '500',
          fontFamily: 'Inter, Roboto, Open Sans, sans-serif',
          fontSize: '16px',
          '::placeholder': { color: '#9ca3af' },
        },
        invalid: { color: '#dc2626' },
      }
    });
    cardElement.mount('#card-element');

    payButton.addEventListener('click', async () => {
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const amount = document.getElementById('amount').value;
      const user_id = 1;
      const product_id = 55;
      const order_id = 'ORD-' + Math.floor(Math.random() * 99999);

      cardErrors.textContent = '';
      successMsg.classList.add('hidden');

      if (!amount || amount <= 0) {
        cardErrors.textContent = 'Por favor ingresa un monto válido.';
        return;
      }

      payButton.disabled = true;
      payButton.textContent = 'Procesando...';

      try {
        // Crear PaymentIntent
        const res = await fetch('/create-payment-intent', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ name, email, amount, user_id, product_id, order_id })
        });

        const data = await res.json();

        if (data.error) {
          throw new Error(data.message);
        }

        const { error, paymentIntent } = await stripe.confirmCardPayment(data.clientSecret, {
          payment_method: { card: cardElement }
        });

        if (error) {
          throw new Error(error.message);
        } else if (paymentIntent.status === 'succeeded') {
          successMsg.classList.remove('hidden');
          payButton.textContent = 'Pagado ✅';
          payButton.disabled = true;
        }
      } catch (err) {
        cardErrors.textContent = err.message;
        payButton.disabled = false;
        payButton.textContent = 'Pagar ahora';
      }
    });
  </script>
</body>
</html>
