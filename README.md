# WordPress Secure Deploy (CSR + Cloud Build)

Este repositorio contiene una imagen lista para desplegar WordPress en Google Cloud Run usando:

- Docker personalizado
- Cloud Source Repositories (CSR)
- Cloud Build CI/CD
- Secrets para conexión a Cloud SQL y WP-Stateless
- Bucket de Google Cloud Storage para almacenamiento sin estado

---

## 🚀 Flujo de despliegue CI/CD

1. Realizas un **push a la rama `main`** de este repositorio (CSR).
2. Cloud Build detecta el cambio usando `.cloudbuild.yaml`.
3. Se construye la imagen Docker personalizada y se sube a Container Registry.
4. Se despliega automáticamente a Cloud Run con secretos y configuración inyectada.

---

## 🧱 Estructura del proyecto

| Archivo                       | Descripción |
|------------------------------|-------------|
| `Dockerfile`                 | Construye la imagen WordPress con Apache + WP-Stateless |
| `entrypoint.sh`              | Espera MySQL, instala WordPress y actualiza la configuración del plugin |
| `wp-config.php`              | Usa `getenv()` para variables y define constantes WP-Stateless |
| `wp-stateless-json-loader.php` | Plugin que intenta cargar el JSON del Service Account |
| `.cloudbuild.yaml`           | Configura el build automático y despliegue a Cloud Run |
| `custom-ports.conf`          | Cambia Apache al puerto 8080 para Cloud Run |

---

## 🔐 Requisitos previos

1. **Cloud SQL** (MySQL) con IP privada
2. **VPC Connector**: `run-vpc-connector`
3. **Secrets creados en Secret Manager**:
   - `DB_PASSWORD`
   - `SERVICE_ACCOUNT_JSON`
4. **Bucket de GCS** creado (ej. `test-stateless-sp`)
5. **Cloud Build activado**
6. **Permisos adecuados** en IAM:
   - `Cloud Run Admin`
   - `Secret Manager Accessor`
   - `Service Account User`

---

## 🔧 Configuración del trigger

Crea un trigger con:

```bash
gcloud builds triggers create cloud-source-repositories \
  --name="wordpress-deploy" \
  --repo="wordpress-secure" \
  --branch-pattern="^main$" \
  --build-config=".cloudbuild.yaml"
```

---

## 🧪 Diagnóstico

- Revisa los logs de Cloud Run para mensajes como:
  - `✅ JSON cargado correctamente`
  - `✅ Base de datos disponible`
- Verifica que las imágenes se suban a GCS correctamente
- Accede a tu instancia WordPress vía la URL de Cloud Run

---

## ✨ Autor

GPA
