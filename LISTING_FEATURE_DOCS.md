# Rental Listing Feature Documentation

## Overview
This feature allows hosts to create, manage, and edit rental property listings through a comprehensive multi-step form. The system includes full CRUD operations with proper authorization and validation.

## Features

### 1. Multi-Step Form (5 Steps)
The listing creation process guides users through:

**Step 1: Address**
- Street Address
- City
- State/Province
- Zip/Postal Code
- Country

**Step 2: Property Type & Capacity**
- Property Type (Apartment, House, Villa, Condo, Townhouse, Cottage, Penthouse, Studio)
- Maximum Guest Capacity
- Number of Bedrooms
- Number of Bathrooms

**Step 3: Title & Description**
- Listing Title (max 255 characters)
- Detailed Description (10-5000 characters)

**Step 4: Amenities**
Checkbox selection from 18 amenities:
- WiFi, TV, Full Kitchen, Parking
- Pool, Gym, Air Conditioning, Heating
- Washer, Dryer, Elevator, Balcony/Terrace
- Garden, Hot Tub, Fireplace, Security System
- Pets Allowed, Furnished

**Step 5: Pricing**
- Price per Night (decimal, min $0.01)
- Interactive summary showing all entered information

### 2. Form Features
- **Progress Indicator**: Visual step progress with completed step tracking
- **Form Validation**: 
  - Real-time client-side validation
  - Server-side validation on submit
  - Custom error messages
  - Field-level error display
- **Data Persistence**: All form data retained when navigating between steps
- **Character Counters**: For title and description fields
- **Summary Display**: Final review of all information before submission

### 3. Listing Management
- **Create**: Multi-step form at `/listings/create`
- **Read**: View listing details at `/listings/{listing}`
- **Update**: Edit listing at `/listings/{listing}/edit`
- **Delete**: Delete listing with confirmation

### 4. Authorization
- Users can only edit/delete their own listings
- Policy-based authorization using `ListingPolicy`
- Automatic owner verification

### 5. Dashboard Integration
The dashboard displays:
- Total listings count
- Published listings count
- Draft listings count
- Grid view of all user's listings with quick actions

## Installation & Setup

### 1. Run Migration
```bash
php artisan migrate
```

This creates the `listings` table with all necessary columns.

### 2. Routes Created
All routes are under `/listings` and require authentication:
- `GET /listings/create` - Show creation form
- `POST /listings` - Store new listing
- `GET /listings/{listing}` - Show listing details
- `GET /listings/{listing}/edit` - Show edit form
- `PATCH /listings/{listing}` - Update listing
- `DELETE /listings/{listing}` - Delete listing

## Database Schema

### Listings Table
```sql
- id: Primary Key
- user_id: Foreign Key to Users
- title: VARCHAR(255)
- description: TEXT
- address: VARCHAR(255)
- city: VARCHAR(100)
- state: VARCHAR(100)
- zip_code: VARCHAR(20)
- country: VARCHAR(100)
- latitude: DECIMAL(10,8) - nullable
- longitude: DECIMAL(11,8) - nullable
- property_type: VARCHAR (enum values)
- guest_capacity: INTEGER
- bedrooms: INTEGER
- bathrooms: INTEGER
- price_per_night: DECIMAL(10,2)
- amenities: JSON (array of amenity keys)
- main_image: VARCHAR(255) - nullable
- images: JSON (array of image paths) - nullable
- status: ENUM ('draft', 'published', 'inactive') - default 'draft'
- timestamps: created_at, updated_at
- soft_deletes: deleted_at
```

## Models & Controllers

### Models
- **Listing** (`app/Models/Listing.php`)
  - Relationships: `belongsTo(User::class)`
  - Accessors: `photo_url`, `image_urls`
  - Casts: JSON fields for amenities and images

- **User** (Updated)
  - New Relationship: `hasMany(Listing::class)`

### Controller
- **ListingController** (`app/Http/Controllers/ListingController.php`)
  - `create()`: Show form
  - `store()`: Process form submission
  - `show()`: Display listing
  - `edit()`: Show edit form
  - `update()`: Process edits
  - `destroy()`: Delete listing
  - Helper methods: `getPropertyTypes()`, `getAmenities()`

### Form Requests
- **StoreListingRequest** (`app/Http/Requests/StoreListingRequest.php`)
  - Validates new listing creation
  - Custom error messages

- **UpdateListingRequest** (`app/Http/Requests/UpdateListingRequest.php`)
  - Validates listing updates
  - Authorization check for ownership

### Policy
- **ListingPolicy** (`app/Policies/ListingPolicy.php`)
  - `update()`: Check ownership
  - `delete()`: Check ownership

## Views

### Create Form
- **Path**: `resources/views/listings/create.blade.php`
- Vue 3 component with reactive form handling
- Multi-step progress indicator
- Real-time validation
- Responsive design

### Show Listing
- **Path**: `resources/views/listings/show.blade.php`
- Display all listing information
- Property information cards
- Amenities display with emojis
- User (host) information
- Edit/Delete buttons for owner
- "Reserve Now" button placeholder

### Edit Form
- **Path**: `resources/views/listings/edit.blade.php`
- Traditional form (non-Vue)
- All fields from creation
- Pre-filled with existing data
- Server-side validation errors

### Dashboard
- **Updated**: `resources/views/dashboard.blade.php`
- Statistics cards
- Grid view of user's listings
- Quick view/edit actions
- Create listing button

## Validation Rules

### Address Fields
- All required
- Max lengths enforced per field
- Country field accepts any string

### Property Details
- Property type: Required, enum validation
- Guest capacity: Integer 1-50
- Bedrooms: Integer 0-20
- Bathrooms: Integer 1-20

### Listing Info
- Title: Required, max 255 chars
- Description: Required, 10-5000 chars

### Pricing
- Price per night: Required, decimal, min 0.01

### Location (Optional)
- Latitude: -90 to 90
- Longitude: -180 to 180

## Usage Examples

### Create a New Listing
1. Click "Create Listing" from dashboard
2. Fill out all 5 steps sequentially
3. Each step validates before allowing progress
4. Final step shows summary
5. Click "Create Listing" to submit

### Edit Existing Listing
1. View listing details
2. Click "Edit" button (owner only)
3. Modify any fields
4. Click "Save Changes"

### View Your Listings
1. Go to Dashboard
2. See statistics and listing grid
3. Click View to see full details
4. Click Edit to modify

## Frontend Technologies
- **Vue 3**: Reactive form handling
- **Tailwind CSS**: Styling
- **Alpine.js**: (if needed for additional interactivity)

## Backend Technologies
- **Laravel 11**: Framework
- **PHP 8.x**: Language
- **MySQL**: Database

## Future Enhancements
1. Image upload functionality for main_image and gallery
2. Google Maps integration for coordinates
3. Listing approval workflow
4. Search and filtering
5. Booking system
6. Guest reviews
7. Dynamic pricing rules
8. Seasonal pricing
9. Bulk operations
10. Export/Import listings

## Notes
- All routes require authentication (`auth` middleware)
- Listing status defaults to 'draft' until manually published
- Soft deletes are enabled for data recovery
- Amenities are stored as JSON array for flexibility
- Proper error handling with custom validation messages
