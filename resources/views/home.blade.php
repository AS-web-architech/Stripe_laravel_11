<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Centered Card</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Main div to center the card -->
  <div class="max-w-md w-full bg-white shadow-md rounded-lg overflow-hidden">
    <!-- Card content -->
    <div class="p-6">
      
      <h2 class="text-2xl font-semibold mb-2">Product: </h2>
      <p class="text-gray-700">Mobile Phone</p>
      <h2 class="text-2xl font-semibold mb-2">Price </h2>
      <p class="text-gray-700">$300</p>
      <form action="{{route('stripe')}}" method="POST">
        @csrf
        <input type="hidden" name="product_name" value="Mobile Phone">
        <input type="hidden" name="price" value="300">
        <input type="hidden" name="quantity" value="1">
        <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Checkout</button>
      </form>
    </div>
  </div>

</body>
</html>
