
(function(){
  // sample dataset - in real app this would come from API
  const hotels = [
    {id:1,name:'SeaView Resort',city:'Goa',price:420,stars:5,desc:'Beachfront resort with infinity pool',img:'https://images.unsplash.com/photo-1501117716987-c8e2e2b0f47a?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=0d7f6d0a3b7c8ad7a1a9e6ff9b8c2b6e'},
    {id:2,name:'Urban Stay',city:'Mumbai',price:320,stars:4,desc:'Modern rooms in the city center',img:'https://images.unsplash.com/photo-1560347876-aeef00ee58a1?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=2c66f6f6e3f2b6a8a7c2d6b8f0a3b1c9'},
    {id:3,name:'Hilltop Inn',city:'Manali',price:270,stars:3,desc:'Cozy inn with mountain view',img:'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=1b36f7b4cb3f99c0f233d3b6a0cb3e9a'},
    {id:4,name:'Lakeside Hotel',city:'Udaipur',price:500,stars:5,desc:'Luxury suites facing the lake',img:'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=d1a2b3c4d5e6f7890a1b2c3d4e5f6a7b'},
    {id:5,name:'Budget Rooms',city:'Jaipur',price:110,stars:2,desc:'Affordable clean rooms',img:'https://images.unsplash.com/photo-1455587734955-081b22074882?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=7890abcd1234567890abcd1234567890'},
    {id:6,name:'City Boutique',city:'Pune',price:360,stars:4,desc:'Boutique stay with great cafe',img:'https://images.unsplash.com/photo-1551892589-865f69869470?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=abcd1234ef567890abcd1234ef567890'}
  ];

  // render helpers
  const hotelGrid = document.getElementById('hotels');
  const dealList = document.getElementById('dealList');
  const priceValue = document.getElementById('priceValue');
  const priceRange = document.getElementById('priceRange');
  const modal = document.getElementById('bookingModal');
  const modalContent = document.getElementById('modalContent');

  function renderHotels(list){
    hotelGrid.innerHTML = '';
    list.forEach(h=>{
      const el = document.createElement('article');
      el.className = 'card';
      el.innerHTML = `
        <div class="thumb" style="background-image:url(${h.img})"></div>
        <div class="content">
          <h3>${h.name}</h3>
          <div class="meta">${h.city} • ${h.stars}★</div>
          <div class="desc">${h.desc}</div>
          <div class="price-row">
            <div class="price">₹ ${h.price}</div>
            <div class="cta"><button class="btn btn-primary" data-id="${h.id}">Book</button></div>
          </div>
        </div>
      `;
      hotelGrid.appendChild(el);
    });
  }

  function renderDeals(){
    dealList.innerHTML = '';
    hotels.slice(0,3).forEach(h=>{
      const d = document.createElement('div'); d.className='deal';
      d.innerHTML = `<strong>${h.name}</strong><div>${h.city}</div><div class="small">From ₹${h.price}/night</div>`;
      dealList.appendChild(d);
    });
  }

  // search & filter
  const form = document.getElementById('searchForm');
  form.addEventListener('submit', function(e){
    e.preventDefault();
    const q = document.getElementById('q').value.trim().toLowerCase();
    const maxPrice = Number(priceRange.value);
    const guests = document.getElementById('guests').value;
    const filtered = hotels.filter(h => {
      const matchesQ = !q || h.name.toLowerCase().includes(q) || h.city.toLowerCase().includes(q);
      const matchesPrice = h.price <= maxPrice;
      return matchesQ && matchesPrice;
    });
    renderHotels(filtered);
  });

  // price control
  priceRange.addEventListener('input', ()=>{priceValue.textContent = priceRange.value});

  // delegate booking clicks
  document.body.addEventListener('click', function(e){
    const target = e.target;
    if(target.matches('.btn-primary') && target.dataset.id){
      const id = Number(target.dataset.id);
      openBooking(id);
    }
    if(target.classList.contains('modal-close')) closeModal();
  });

  function openBooking(id){
    const hotel = hotels.find(h=>h.id===id);
    if(!hotel) return;
    modalContent.innerHTML = `
      <h3>Book: ${hotel.name}</h3>
      <p class="small">${hotel.city} • ${hotel.stars}★</p>
      <p>${hotel.desc}</p>
      <form id="bookForm">
        <label>Full name <input required name="name" /></label>
        <label>Email <input required name="email" type="email" /></label>
        <label>Rooms <select name="rooms"><option>1</option><option>2</option></select></label>
        <div style="display:flex;gap:.6rem;margin-top:.8rem"><button type="submit" class="btn btn-primary">Confirm</button><button type="button" class="btn btn-ghost modal-close">Cancel</button></div>
      </form>
    `;
    modal.setAttribute('aria-hidden','false');

    const bf = document.getElementById('bookForm');
    bf.addEventListener('submit', function(ev){
      ev.preventDefault();
      const formData = new FormData(bf);
      // pretend booking success
      modalContent.innerHTML = `<h3>Booking confirmed</h3><p>Thanks, ${formData.get('name')}. A confirmation has been sent to ${formData.get('email')}.</p>`;
      setTimeout(closeModal,2000);
    });
  }

  function closeModal(){ modal.setAttribute('aria-hidden','true'); }

  // initial render
  document.getElementById('year').textContent = new Date().getFullYear();
  renderHotels(hotels);
  renderDeals();

  // accessibility: close modal with Esc
  document.addEventListener('keydown', e => { if(e.key === 'Escape') closeModal(); });

})();