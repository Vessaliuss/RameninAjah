//Menu Section Start
const menuItems = [
  { name: 'Ramen Chashu Deluxe', image: './Gallery/img1.png', price: 'Rp50,000' },
  { name: 'Ramen Beef Classic', image: './Gallery/img2.png', price: 'Rp45,000' },
  { name: 'Ramen Seafood Supreme', image: './Gallery/img3.png', price: 'Rp55,000' },
  { name: 'Ramen Gyoza Combo', image: './Gallery/img4.png', price: 'Rp52,000' },
  { name: 'Ramen Prawn Delight', image: './Gallery/img5.png', price: 'Rp52,000' },
  { name: 'Ramen Tempura Special', image: './Gallery/img6.png', price: 'Rp55,000' },
  { name: 'Ramen Miso Traditional', image: './Gallery/img7.png', price: 'Rp50,000' },
  { name: 'Ramen Pork Belly Delight', image: './Gallery/img8.png', price: 'Rp53,000' },
  { name: 'Ramen Steakhouse Style', image: './Gallery/img9.png', price: 'Rp60,000' },
  { name: 'Ramen Yakibuta Special', image: './Gallery/img10.png', price: 'Rp57,000' },
  { name: 'Ramen Chicken Teriyaki', image: './Gallery/img11.png', price: 'Rp45,000' },
  { name: 'Ramen Sushi Fusion', image: './Gallery/img12.png', price: 'Rp62,000' },
  { name: 'Kanikama Ankake Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/5/3/w8vuzsc4ddq7kedyle29js_size_400_webp.webp', price: 'Rp42,000' },
  { name: 'Kotteri Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/5/31/ibznygp7df5icmmtnbg48u_size_400_webp.webp', price: 'Rp45,000' },
  { name: 'Teriyaki Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/hia2rn8frordec5ntug6em_size_400_webp.webp', price: 'Rp43,000' },
  { name: 'Spicy Oden Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/4/21/hf3agj4caumysggmxhtrxs_size_400_webp.webp', price: 'Rp42,000' },
  { name: 'Beef Abura Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/6/28/k7lmhh7nt6mzrqzggexhwy_size_400_webp.webp', price: 'Rp41,000' },
  { name: 'Beef Abura Spicy Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/6/28/gbbfv9pycqf6xjxr8hynsc_size_400_webp.webp', price: 'Rp41,000' },
  { name: 'Beef Curry Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/m6sssc9kfapmgkxrg83gq2_size_400_webp.webp', price: 'Rp45,000' },
  { name: 'Chicken Katsu Curry Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/hxrhvebqntc3bdz2nlaf66_size_400_webp.webp', price: 'Rp50,000' },
  { name: 'Kake Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/wtr5vpcsdedoejb6zg5yas_size_400_webp.webp', price: 'Rp37,000' },
  { name: 'Niku Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/dm9sqkbjbfinrenxgayg6z_size_400_webp.webp', price: 'Rp36,000' },
  { name: 'Spicy Tori Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/jqrlpzh955agafxgoqwrxg_size_400_webp.webp', price: 'Rp40,000' },
  { name: 'Niku Zaru Udon', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/tdmfy6n8epnjyzkkzspr62_size_400_webp.webp', price: 'Rp39,000' },
  { name: 'Hot Ocha', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/5/17/nu4zv7ptleazynsdpnzqsw_size_400_webp.webp', price: 'Rp14,000' },
  { name: 'Iced Lemon Tea', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/5/17/wb5tnxte8by5afugrzfazc_size_400_webp.webp', price: 'Rp15,000' },
  { name: 'Aqua', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/olz56f9i92qpvdakvar3y7_size_400_webp.webp', price: 'Rp8,000' },
  { name: 'Coca Cola', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2023/10/16/3b8etkf9eggxap49whn7er_size_400_webp.webp', price: 'Rp15,000' },
  { name: 'Cold Ocha', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/5/17/anzkdewejqwdpku4pth2oe_size_400_webp.webp', price: 'Rp14,000' },
  { name: 'Cafe Latte', image: 'https://www.marugameudon.co.id/omni-media/thumb/product_photo/2024/5/17/cnxbbj7l3t4f7qbaveghtl_size_400_webp.webp', price: 'Rp25,000' },
];

function renderMenuItems(items) {
  const menuContainer = document.getElementById('menuContainer');
  menuContainer.innerHTML = '';
  items.forEach(item => {
      const menuItem = document.createElement('div');
      menuItem.className = 'menu_item';
      menuItem.innerHTML = `
          <img src="${item.image}" alt="${item.name}">
          <h5>${item.name}</h5>
          <p>${item.price}</p>
      `;
      menuContainer.appendChild(menuItem);
  });
}

document.getElementById('searchInput').addEventListener('input', (event) => {
  const query = event.target.value.toLowerCase();
  const filteredItems = menuItems.filter(item => item.name.toLowerCase().includes(query));
  renderMenuItems(filteredItems);
});

window.onload = () => {
  renderMenuItems(menuItems);
};
//Menu Section Closed . tambahkan display harga
