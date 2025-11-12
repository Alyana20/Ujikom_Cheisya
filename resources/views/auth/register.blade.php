<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-center text-lg font-semibold text-gray-700 mb-6">FORM REGISTRASI</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="name" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Retype Password</label>
                    <input type="password" name="password_confirmation" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="birth_date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <div class="flex items-center gap-4 mt-1">
                        <label><input type="radio" name="gender" value="Male"> Male</label>
                        <label><input type="radio" name="gender" value="Female"> Female</label>
                    </div>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">City</label>
                    <select name="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option>Jakarta</option>
                        <option>Surabaya</option>
                        <option>Bandung</option>
                        <option>Yogyakarta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact No</label>
                    <input type="text" name="contact" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <!-- Role -->
            <div class="mt-4">
                <x-input-label for="role" :value="__('Daftar Sebagai')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="customer">Customer</option>
                    <option value="vendor">Vendor</option>
                </select>
            </div>


            <div class="flex justify-center gap-4 mt-6">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Submit</button>
                <button type="reset"
                    class="bg-gray-400 text-white px-6 py-2 rounded-md hover:bg-gray-500">Clear</button>
            </div>
        </form>
    </div>
</x-guest-layout>
