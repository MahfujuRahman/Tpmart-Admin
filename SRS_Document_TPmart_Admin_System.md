# Software Requirements Specification (SRS)
## TPmart E-commerce Admin Management System

---

**Document Version:** 1.0  
**Date:** July 31, 2025  
**Project:** TPmart E-commerce Admin Backend System  
**Technology Stack:** Laravel 8+, PHP 8+, MySQL  

---

## Table of Contents

1. [Introduction](#1-introduction)
2. [Overall Description](#2-overall-description)
3. [System Features](#3-system-features)
4. [External Interface Requirements](#4-external-interface-requirements)
5. [System Requirements](#5-system-requirements)
6. [Database Design](#6-database-design)
7. [API Specifications](#7-api-specifications)
8. [Security Requirements](#8-security-requirements)
9. [Performance Requirements](#9-performance-requirements)
10. [Quality Attributes](#10-quality-attributes)

---

## 1. Introduction

### 1.1 Purpose
This Software Requirements Specification (SRS) document provides a comprehensive description of the TPmart E-commerce Admin Management System. The document outlines the functional and non-functional requirements, system architecture, and technical specifications for a robust backend administration platform designed to manage all aspects of an e-commerce operation.

### 1.2 Scope
The TPmart Admin System is a comprehensive backend management platform that encompasses:
- **Product Management**: Complete product lifecycle management including variants, packages, and inventory
- **Order Management**: End-to-end order processing, tracking, and fulfillment
- **Customer Relationship Management (CRM)**: Customer data, communication, and support systems
- **Inventory Management**: Real-time stock tracking, warehouse management, and purchase orders
- **Financial Management**: Accounting, transactions, payments, and reporting
- **Content Management**: Website content, blogs, banners, and SEO management
- **User & Role Management**: Multi-level user access control and permission systems
- **API Services**: RESTful APIs for mobile and web applications

### 1.3 Definitions, Acronyms, and Abbreviations
- **SRS**: Software Requirements Specification
- **API**: Application Programming Interface
- **CRM**: Customer Relationship Management
- **SKU**: Stock Keeping Unit
- **COD**: Cash on Delivery
- **JWT**: JSON Web Token
- **CRUD**: Create, Read, Update, Delete
- **MVC**: Model-View-Controller

### 1.4 References
- Laravel Framework Documentation
- PHP 8+ Documentation
- MySQL Database Documentation
- RESTful API Design Standards

---

## 2. Overall Description

### 2.1 Product Perspective
The TPmart Admin System is a standalone backend application built on the Laravel framework, designed to serve as the central management hub for e-commerce operations. The system provides:

- **Web-based Administrative Interface**: Complete admin dashboard for system management
- **RESTful API Layer**: Comprehensive APIs for mobile applications and third-party integrations
- **Database Management**: Robust MySQL database structure for data persistence
- **File Management**: Integrated file upload and management system
- **Reporting System**: Advanced analytics and reporting capabilities

### 2.2 Product Functions
The system provides the following major functional areas:

#### 2.2.1 Authentication & Authorization
- Multi-level user authentication system
- Role-based access control (RBAC)
- JWT token-based API authentication
- Social login integration
- Password recovery and account management

#### 2.2.2 E-commerce Management
- Product catalog management with variants
- Package product creation and management
- Order processing and fulfillment
- Payment gateway integration
- Shipping and delivery management

#### 2.2.3 Inventory Control
- Real-time stock tracking
- Warehouse and room-based inventory
- Purchase order management
- Supplier relationship management
- Stock alerts and notifications

#### 2.2.4 Customer Management
- Customer profile management
- Order history tracking
- Support ticket system
- Communication management
- Customer analytics

#### 2.2.5 Financial Operations
- Transaction recording and tracking
- Payment method management
- Expense categorization
- Ledger and accounting reports
- Revenue analytics

#### 2.2.6 Content Management
- Website content management
- Blog and article publishing
- Banner and slider management
- SEO optimization tools
- Multi-media file management

### 2.3 User Classes and Characteristics

#### 2.3.1 Super Administrator
- **Access Level**: Full system access
- **Responsibilities**: System configuration, user management, security oversight
- **Technical Expertise**: High

#### 2.3.2 Administrator
- **Access Level**: Most system functions
- **Responsibilities**: Daily operations management, order processing, inventory management
- **Technical Expertise**: Medium

#### 2.3.3 Manager
- **Access Level**: Department-specific functions
- **Responsibilities**: Team management, reporting, specific module oversight
- **Technical Expertise**: Medium

#### 2.3.4 Employee
- **Access Level**: Limited operational functions
- **Responsibilities**: Data entry, order processing, customer support
- **Technical Expertise**: Basic

#### 2.3.5 API Users (Mobile/Web Applications)
- **Access Level**: Programmatic access via APIs
- **Responsibilities**: Data consumption and submission
- **Technical Expertise**: Developer-level

### 2.4 Operating Environment
- **Server Environment**: Linux/Ubuntu Server
- **Web Server**: Apache/Nginx
- **Database**: MySQL 8.0+
- **PHP Version**: 8.0+
- **Framework**: Laravel 8+
- **Frontend**: Blade Templates with Bootstrap
- **API Format**: RESTful JSON APIs

---

## 3. System Features

### 3.1 Authentication Module

#### 3.1.1 Description
Comprehensive authentication and authorization system supporting multiple user types and access levels.

#### 3.1.2 Functional Requirements
- **FR-3.1.1**: User login with email/username and password
- **FR-3.1.2**: Multi-factor authentication support
- **FR-3.1.3**: Social login integration (Google, Facebook)
- **FR-3.1.4**: Password reset via email
- **FR-3.1.5**: Session management and timeout
- **FR-3.1.6**: API authentication using JWT tokens
- **FR-3.1.7**: Role-based access control

#### 3.1.3 Input/Output Specifications
- **Input**: User credentials, reset tokens, social auth tokens
- **Output**: Authentication status, user profile, access tokens

### 3.2 Product Management Module

#### 3.2.1 Description
Complete product lifecycle management including creation, variants, packages, and inventory tracking.

#### 3.2.2 Functional Requirements
- **FR-3.2.1**: Create and manage product catalog
- **FR-3.2.2**: Product variant management (color, size, storage, etc.)
- **FR-3.2.3**: Package product creation with multiple items
- **FR-3.2.4**: Product categorization and subcategorization
- **FR-3.2.5**: Product image and media management
- **FR-3.2.6**: Inventory tracking and stock management
- **FR-3.2.7**: Product pricing and discount management
- **FR-3.2.8**: Product SEO optimization
- **FR-3.2.9**: Product review and rating system
- **FR-3.2.10**: Product question and answer system

#### 3.2.3 Key Features
- **Complex Variant System**: Support for multiple variant types including color, size, storage, region, SIM type, warranty, and device condition
- **Package Products**: Ability to create bundles with multiple products and variants
- **Duplicate Detection**: Advanced validation to prevent duplicate variant combinations
- **Stock Management**: Real-time stock tracking with warehouse and room-level organization
- **Media Management**: Multiple image support with drag-and-drop functionality

### 3.3 Order Management Module

#### 3.3.1 Description
End-to-end order processing system from placement to delivery with comprehensive tracking.

#### 3.3.2 Functional Requirements
- **FR-3.3.1**: Order creation and modification
- **FR-3.3.2**: Order status tracking (Pending, Approved, Dispatch, Transit, Delivered, Cancelled)
- **FR-3.3.3**: Payment processing and status management
- **FR-3.3.4**: Shipping and delivery management
- **FR-3.3.5**: Order cancellation and refund processing
- **FR-3.3.6**: Invoice generation and printing
- **FR-3.3.7**: Order analytics and reporting
- **FR-3.3.8**: Delivery man assignment and tracking

#### 3.3.3 Order Workflow
1. **Order Placement**: Customer places order via API or admin interface
2. **Validation**: System validates product availability and pricing
3. **Payment Processing**: Integration with multiple payment gateways
4. **Order Confirmation**: Automatic confirmation and notification
5. **Fulfillment**: Inventory allocation and picking
6. **Shipping**: Delivery assignment and tracking
7. **Completion**: Delivery confirmation and feedback collection

### 3.4 Inventory Management Module

#### 3.4.1 Description
Comprehensive inventory control system with warehouse management and procurement features.

#### 3.4.2 Functional Requirements
- **FR-3.4.1**: Multi-warehouse inventory tracking
- **FR-3.4.2**: Room and cartoon-level organization
- **FR-3.4.3**: Purchase order management
- **FR-3.4.4**: Supplier relationship management
- **FR-3.4.5**: Stock level monitoring and alerts
- **FR-3.4.6**: Inventory valuation and costing
- **FR-3.4.7**: Stock movement tracking
- **FR-3.4.8**: Procurement quotation management

#### 3.4.3 Warehouse Structure
- **Warehouse**: Top-level storage facility
- **Room**: Subdivision within warehouse
- **Cartoon**: Specific storage unit within room
- **Product Allocation**: Individual product placement tracking

### 3.5 Customer Relationship Management (CRM)

#### 3.5.1 Description
Complete customer lifecycle management with communication and support capabilities.

#### 3.5.2 Functional Requirements
- **FR-3.5.1**: Customer profile management
- **FR-3.5.2**: Customer categorization and segmentation
- **FR-3.5.3**: Communication history tracking
- **FR-3.5.4**: Support ticket system
- **FR-3.5.5**: Customer analytics and insights
- **FR-3.5.6**: Marketing campaign management
- **FR-3.5.7**: Customer feedback collection
- **FR-3.5.8**: Loyalty program management

### 3.6 Financial Management Module

#### 3.6.1 Description
Comprehensive accounting and financial tracking system.

#### 3.6.2 Functional Requirements
- **FR-3.6.1**: Transaction recording and categorization
- **FR-3.6.2**: Payment method management
- **FR-3.6.3**: Expense tracking and categorization
- **FR-3.6.4**: Revenue and profit calculation
- **FR-3.6.5**: Financial reporting and analytics
- **FR-3.6.6**: Ledger management
- **FR-3.6.7**: Tax calculation and reporting
- **FR-3.6.8**: Budget planning and tracking

### 3.7 Content Management System

#### 3.7.1 Description
Web content management for marketing and SEO optimization.

#### 3.7.2 Functional Requirements
- **FR-3.7.1**: Website page content management
- **FR-3.7.2**: Blog and article publishing
- **FR-3.7.3**: Banner and slider management
- **FR-3.7.4**: SEO meta tag management
- **FR-3.7.5**: FAQ management
- **FR-3.7.6**: Terms and policy page management
- **FR-3.7.7**: Testimonial management
- **FR-3.7.8**: Gallery and media management

### 3.8 API Management Module

#### 3.8.1 Description
RESTful API layer for mobile applications and third-party integrations.

#### 3.8.2 API Categories

#### 3.8.2.1 Authentication APIs
- User registration and verification
- Login and token management
- Password recovery
- Social login integration

#### 3.8.2.2 Product APIs
- Product catalog retrieval
- Category and brand listing
- Product search and filtering
- Product details and variants

#### 3.8.2.3 Order APIs
- Order placement and checkout
- Order history and tracking
- Payment processing
- Order status updates

#### 3.8.2.4 Customer APIs
- Profile management
- Address management
- Wishlist functionality
- Review and rating submission

#### 3.8.2.5 Cart APIs
- Add/remove items
- Quantity management
- Coupon application
- Checkout processing

---

## 4. External Interface Requirements

### 4.1 User Interfaces

#### 4.1.1 Administrative Web Interface
- **Technology**: Blade templates with Bootstrap 4/5
- **Features**: Responsive design, intuitive navigation, role-based dashboards
- **Components**: Data tables, forms, charts, modals, notifications

#### 4.1.2 API Interface
- **Format**: JSON REST APIs
- **Authentication**: JWT token-based
- **Documentation**: Comprehensive API documentation
- **Rate Limiting**: Configurable request throttling

### 4.2 Hardware Interfaces
- **Minimum Server Specifications**:
  - CPU: 2+ cores
  - RAM: 4GB minimum, 8GB recommended
  - Storage: 50GB minimum
  - Network: High-speed internet connection

### 4.3 Software Interfaces

#### 4.3.1 Database Interface
- **Database**: MySQL 8.0+
- **Connection**: PDO with connection pooling
- **Features**: Transactions, foreign keys, indexing

#### 4.3.2 External Services
- **Payment Gateways**: SSLCommerz, bKash, Nagad
- **SMS Services**: Configurable SMS providers
- **Email Services**: SMTP configuration
- **File Storage**: Local and cloud storage options

### 4.4 Communication Interfaces
- **HTTP/HTTPS**: Web interface and API communication
- **WebSocket**: Real-time notifications (future enhancement)
- **Email**: SMTP for notifications and communications
- **SMS**: Gateway integration for notifications

---

## 5. System Requirements

### 5.1 Performance Requirements

#### 5.1.1 Response Time
- **Web Interface**: < 3 seconds for page loads
- **API Responses**: < 1 second for standard requests
- **Database Queries**: < 500ms for complex queries
- **File Uploads**: Support for files up to 10MB

#### 5.1.2 Throughput
- **Concurrent Users**: Support for 100+ simultaneous users
- **API Requests**: 1000+ requests per minute
- **Database Connections**: Connection pooling for optimization

#### 5.1.3 Scalability
- **Horizontal Scaling**: Load balancer support
- **Database Scaling**: Read replica support
- **Caching**: Redis/Memcached integration
- **CDN Integration**: Static asset delivery optimization

### 5.2 Security Requirements

#### 5.2.1 Authentication & Authorization
- **Password Policy**: Minimum 8 characters with complexity requirements
- **Session Management**: Secure session handling with timeout
- **Multi-Factor Authentication**: Optional 2FA support
- **Role-Based Access**: Granular permission system

#### 5.2.2 Data Protection
- **Encryption**: HTTPS for all communications
- **Database Security**: Encrypted sensitive data
- **File Security**: Secure file upload validation
- **Input Validation**: SQL injection and XSS prevention

#### 5.2.3 Audit & Logging
- **Activity Logging**: Comprehensive user action logging
- **Error Logging**: Detailed error tracking
- **Security Logging**: Failed login attempts and security events
- **Data Backup**: Regular automated backups

### 5.3 Reliability Requirements
- **Uptime**: 99.9% availability target
- **Error Handling**: Graceful error recovery
- **Data Integrity**: ACID compliance for transactions
- **Backup & Recovery**: Daily backups with point-in-time recovery

---

## 6. Database Design

### 6.1 Database Architecture
The system uses a relational database design with the following key characteristics:
- **Normalization**: 3NF compliant design
- **Referential Integrity**: Foreign key constraints
- **Indexing**: Optimized query performance
- **Partitioning**: Large table optimization

### 6.2 Core Entity Relationships

#### 6.2.1 Product Entities
```
products (main product table)
├── product_variants (color, size, storage variants)
├── product_images (multiple product images)
├── package_product_items (for package products)
├── categories (product categorization)
├── subcategories (product subcategorization)
├── childcategories (third-level categorization)
├── brands (product brands)
├── colors (available colors)
├── product_sizes (available sizes)
└── units (measurement units)
```

#### 6.2.2 Order Entities
```
orders (main order table)
├── order_details (order line items)
├── order_progress (status tracking)
├── shipping_infos (delivery information)
├── billing_addresses (billing information)
├── order_payments (payment records)
└── order_delivery_men (delivery assignments)
```

#### 6.2.3 User Entities
```
users (main user table)
├── user_roles (role assignments)
├── roles (available roles)
├── permissions (system permissions)
├── role_permissions (role-permission mapping)
└── user_addresses (multiple user addresses)
```

#### 6.2.4 Inventory Entities
```
product_warehouses (warehouse locations)
├── product_warehouse_rooms (warehouse rooms)
├── product_warehouse_room_cartoons (storage units)
├── product_stocks (inventory records)
├── product_suppliers (supplier information)
└── purchase_orders (procurement records)
```

### 6.3 Key Database Tables

#### 6.3.1 Products Table
```sql
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT,
    subcategory_id BIGINT,
    childcategory_id BIGINT,
    brand_id BIGINT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(100),
    image VARCHAR(255),
    price DECIMAL(10,2) DEFAULT 0,
    discount_price DECIMAL(10,2) DEFAULT 0,
    stock DECIMAL(8,2) DEFAULT 0,
    has_variant TINYINT DEFAULT 0,
    is_package BOOLEAN DEFAULT FALSE,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### 6.3.2 Package Product Items Table
```sql
CREATE TABLE package_product_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    package_product_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    color_id BIGINT NULL,
    size_id BIGINT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### 6.3.3 Product Variants Table
```sql
CREATE TABLE product_variants (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL,
    color_id BIGINT NULL,
    size_id BIGINT NULL,
    region_id BIGINT NULL,
    sim_id BIGINT NULL,
    storage_type_id BIGINT NULL,
    stock DECIMAL(8,2) DEFAULT 0,
    price DECIMAL(10,2) DEFAULT 0,
    discounted_price DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 7. API Specifications

### 7.1 API Architecture
- **Style**: RESTful
- **Format**: JSON
- **Authentication**: JWT Bearer Token
- **Versioning**: URL-based versioning
- **Error Handling**: Standardized error responses

### 7.2 Authentication APIs

#### 7.2.1 User Registration
```
POST /api/user/registration
Content-Type: application/json

Request:
{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "password": "securePassword123"
}

Response:
{
    "status": "success",
    "message": "Registration successful",
    "data": {
        "user_id": 123,
        "verification_required": true
    }
}
```

#### 7.2.2 User Login
```
POST /api/user/login
Content-Type: application/json

Request:
{
    "email": "john@example.com",
    "password": "securePassword123"
}

Response:
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "user": {
            "id": 123,
            "name": "John Doe",
            "email": "john@example.com"
        }
    }
}
```

### 7.3 Product APIs

#### 7.3.1 Get All Products
```
GET /api/get/all/products
Authorization: Bearer {token}

Response:
{
    "status": "success",
    "data": {
        "products": [
            {
                "id": 1,
                "name": "Product Name",
                "price": 99.99,
                "image": "path/to/image.jpg",
                "has_variant": true,
                "is_package": false
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 10,
            "total_items": 100
        }
    }
}
```

#### 7.3.2 Get Product Details
```
GET /api/product/details/{id}
Authorization: Bearer {token}

Response:
{
    "status": "success",
    "data": {
        "product": {
            "id": 1,
            "name": "Product Name",
            "description": "Product description",
            "price": 99.99,
            "variants": [
                {
                    "id": 1,
                    "color": "Red",
                    "size": "Large",
                    "stock": 10,
                    "price": 99.99
                }
            ],
            "images": ["image1.jpg", "image2.jpg"]
        }
    }
}
```

### 7.4 Order APIs

#### 7.4.1 Create Order
```
POST /api/order/checkout
Authorization: Bearer {token}
Content-Type: application/json

Request:
{
    "products": [
        {
            "product_id": 1,
            "variant_id": 2,
            "quantity": 2
        }
    ],
    "shipping_address": {
        "name": "John Doe",
        "phone": "+1234567890",
        "address": "123 Main St",
        "city": "City",
        "postal_code": "12345"
    },
    "payment_method": "cod"
}

Response:
{
    "status": "success",
    "message": "Order placed successfully",
    "data": {
        "order_id": "ORD-2025-001",
        "total_amount": 199.98,
        "payment_status": "pending"
    }
}
```

### 7.5 Error Response Format
```json
{
    "status": "error",
    "message": "Error description",
    "errors": {
        "field_name": ["Validation error message"]
    },
    "code": "ERROR_CODE"
}
```

---

## 8. Security Requirements

### 8.1 Authentication Security
- **Password Hashing**: bcrypt with salt
- **JWT Tokens**: RS256 algorithm with expiration
- **Session Security**: HttpOnly, Secure, SameSite cookies
- **Brute Force Protection**: Rate limiting on login attempts

### 8.2 Data Security
- **Input Validation**: Server-side validation for all inputs
- **SQL Injection Prevention**: Parameterized queries
- **XSS Prevention**: Output encoding and CSP headers
- **CSRF Protection**: CSRF tokens for state-changing operations

### 8.3 API Security
- **Rate Limiting**: Throttling to prevent abuse
- **CORS Configuration**: Restricted cross-origin requests
- **Input Sanitization**: Validation and sanitization of API inputs
- **Response Filtering**: Sensitive data exclusion from responses

### 8.4 File Security
- **Upload Validation**: File type and size restrictions
- **Virus Scanning**: Malware detection for uploads
- **Path Traversal Prevention**: Secure file path handling
- **Access Control**: Authenticated access to uploaded files

---

## 9. Performance Requirements

### 9.1 System Performance Metrics
- **Page Load Time**: < 3 seconds for 95% of requests
- **API Response Time**: < 1 second for standard operations
- **Database Query Time**: < 500ms for complex queries
- **Concurrent Users**: Support for 500+ simultaneous users

### 9.2 Optimization Strategies
- **Database Optimization**: Indexing, query optimization, connection pooling
- **Caching**: Redis for session and application caching
- **CDN Integration**: Static asset delivery optimization
- **Code Optimization**: Lazy loading, pagination, efficient algorithms

### 9.3 Monitoring and Analytics
- **Performance Monitoring**: Real-time performance tracking
- **Error Tracking**: Comprehensive error logging and alerting
- **Usage Analytics**: User behavior and system usage analysis
- **Capacity Planning**: Resource usage monitoring and forecasting

---

## 10. Quality Attributes

### 10.1 Reliability
- **Uptime Target**: 99.9% availability
- **Error Recovery**: Graceful degradation and recovery mechanisms
- **Data Consistency**: ACID compliance for critical operations
- **Backup Strategy**: Automated daily backups with point-in-time recovery

### 10.2 Maintainability
- **Code Quality**: PSR standards compliance
- **Documentation**: Comprehensive code and API documentation
- **Testing**: Unit tests, integration tests, and automated testing
- **Version Control**: Git-based version control with branching strategy

### 10.3 Usability
- **User Interface**: Intuitive and responsive design
- **Error Messages**: Clear and actionable error messages
- **Help System**: Contextual help and documentation
- **Accessibility**: WCAG compliance for accessibility

### 10.4 Scalability
- **Horizontal Scaling**: Load balancer and multi-server support
- **Database Scaling**: Read replicas and sharding capabilities
- **Microservices Ready**: Modular architecture for future decomposition
- **Cloud Integration**: Cloud deployment and auto-scaling support

---

## Appendices

### Appendix A: Database Schema Diagram
[Detailed ER diagrams would be included here]

### Appendix B: API Collection
[Postman collection or similar API documentation]

### Appendix C: User Interface Mockups
[Screenshots and wireframes of the admin interface]

### Appendix D: Deployment Guide
[Step-by-step deployment instructions]

### Appendix E: Testing Strategy
[Comprehensive testing approach and test cases]

---

**Document Control**
- **Created By**: Development Team
- **Reviewed By**: Project Manager
- **Approved By**: System Architect
- **Last Updated**: July 31, 2025
- **Next Review**: January 31, 2026
