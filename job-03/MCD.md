# Modèle Conceptuel de Données (MCD)

## Entités

### CATEGORY
- **id** (INT, PK)
- name (VARCHAR)
- description (TEXT)
- createdAt (DATETIME)
- updatedAt (DATETIME)

### PRODUCT
- **id** (INT, PK)
- name (VARCHAR)
- photos (TEXT) - stocké en JSON
- price (INT) - en centimes
- description (TEXT)
- quantity (INT)
- category_id (INT, FK)
- createdAt (DATETIME)
- updatedAt (DATETIME)

## Relations

**CATEGORY** ──< (1,n) ──< **PRODUCT**

Une catégorie peut contenir plusieurs produits (1,n)
Un produit appartient à une seule catégorie (1,1)

## Diagramme textuel

```
┌─────────────────┐         ┌─────────────────┐
│    CATEGORY     │         │     PRODUCT     │
├─────────────────┤         ├─────────────────┤
│ id (PK)         │1       n│ id (PK)         │
│ name            │─────────│ name            │
│ description     │         │ photos          │
│ createdAt       │         │ price           │
│ updatedAt       │         │ description     │
└─────────────────┘         │ quantity        │
                            │ category_id(FK) │
                            │ createdAt       │
                            │ updatedAt       │
                            └─────────────────┘
```
