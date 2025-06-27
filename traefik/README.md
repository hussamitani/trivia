# Traefik v2 HTTPS (SSL) on localhost

Generate certificates using [mkcert](https://github.com/FiloSottile/mkcert) :

If it's the first install of mkcert, run
```bash
mkcert -install
```

Generate local ssl certificates
```bash
mkcert -cert-file certs/local-cert.pem -key-file certs/local-key.pem "docker.localhost" "*.docker.localhost" "domain.local" "*.domain.local"
```

*Note: you can access to Traefik dashboard at: [traefik.docker.localhost](https://traefik.docker.localhost)*
