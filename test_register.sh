#!/bin/bash

# Test user registration
curl -X POST http://localhost/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "esraa",
    "phone": "01012345678",
    "password": "Esraa123"
  }'
