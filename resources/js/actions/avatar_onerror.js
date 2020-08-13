(() => {
    let avatars = document.querySelectorAll('img[data-avatar]');
    for (let avatar of avatars) {
        avatar.onerror = (event) => {
            // avatar.src = '/assets/img/avatar/default_x64.webp';
            avatar.src = 'data:image/webp;base64,UklGRnoCAABXRUJQVlA4IG4CAABwDACdASpAAEAAPm0sk0akIiGhKhZtEIANiWUA0wjgCAbY/noNMW3kp9TmKdgQYEqCGdeRJyARFWW5s5J1XUizsN4JAQi0woSJI/VS/fNsRTZdTx85ftRWhIUDaPn2jDbB3+8fzKyI3A6Zn6AA/vzuO7fMOCm35//iVR/uavSF4F3S4bwuPZdy3ui1tr6g7hAKuF5albF7DQbkHlVJptZ9C7RqX+vOyiNYeFNfY87JeSxxx3POxiNU1F1wW9FbZo+Hd6/K01q882mgF3jVa5anKmAMB8Oo8yvPyuhsWH4wAsc8JJYZqciP6LKVnrd1+WCt07g76w3AsdRLHAPAA3P8Zd9oFBhOYEwn042VgkjEJ8m0BdoV0N+Vy6w/s2v7iEhQpvhaTaqElNfTIlIGSirT/AHrliyjw338GLswHZa9B/9L0IRzSsUbmM13XX4oxL8flgqSCQELjhSOlovQr2Uvj2V/bHhU5yvCex5MnLqo6gZHXX1J7rEDFS9Y5FVI19Zfd7UcuUXpA2OZLzSloPvPHhajX/6H3AEzdsC/T2WWBBOB4DeOGgLbCC+SCZD/AKjDq6YyXdxXdQsK3rSv8YwcCX9uFhmjbrGc4+ekMyqhSppD5NsDM0TG4wPUkh7RfdEYmL+GQn7pOT3pSuX+ZFhqk+3ZvQ9GyK2DKiksrt/d25e9P1cHe58ATKmP4xK/Y9QL74w6PX2zUdviyl1VOAMS3sMNz710ukBq7XHKZPluC19pNnya4Ld5mZSlKLpC1pSNbHb5stMB6UJuIi8cWRePBEWNrO0orwgff0A5YwNtV/axXc/QM6vPB6uvmIAA';
        }
    }
})();
