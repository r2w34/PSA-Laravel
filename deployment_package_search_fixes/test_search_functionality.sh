#!/bin/bash

# PSA-NASHIK Search Functionality Test Script
# Run this script to verify search functionality after deployment

echo "🧪 Testing PSA-NASHIK Search Functionality..."
echo "=============================================="

# Configuration
BASE_URL="http://localhost:5000"
EXTERNAL_URL="http://194.238.23.217"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

print_test() {
    echo -e "${BLUE}[TEST]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[PASS]${NC} $1"
}

print_error() {
    echo -e "${RED}[FAIL]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

# Test 1: Basic Application Health
print_test "1. Testing basic application health..."
HEALTH_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/api/health" 2>/dev/null || echo "000")
if [ "$HEALTH_STATUS" = "200" ]; then
    print_success "Application health check passed (HTTP $HEALTH_STATUS)"
else
    print_error "Application health check failed (HTTP $HEALTH_STATUS)"
fi

# Test 2: Students API Endpoint
print_test "2. Testing students API endpoint..."
STUDENTS_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/api/students" 2>/dev/null || echo "000")
if [ "$STUDENTS_STATUS" = "200" ]; then
    print_success "Students API endpoint accessible (HTTP $STUDENTS_STATUS)"
else
    print_error "Students API endpoint failed (HTTP $STUDENTS_STATUS)"
fi

# Test 3: Student Search Functionality
print_test "3. Testing student search functionality..."
SEARCH_RESPONSE=$(curl -s "$BASE_URL/api/students?search=Test" 2>/dev/null)
SEARCH_STATUS=$?

if [ $SEARCH_STATUS -eq 0 ]; then
    # Check if response contains expected JSON structure
    if echo "$SEARCH_RESPONSE" | grep -q '"students"'; then
        STUDENT_COUNT=$(echo "$SEARCH_RESPONSE" | grep -o '"students":\[.*\]' | grep -o '\[.*\]' | grep -o ',' | wc -l)
        STUDENT_COUNT=$((STUDENT_COUNT + 1))
        if echo "$SEARCH_RESPONSE" | grep -q '\[\]'; then
            STUDENT_COUNT=0
        fi
        print_success "Student search API working - Found $STUDENT_COUNT students for 'Test'"
        
        # Show sample response (first 200 characters)
        echo "Sample response: ${SEARCH_RESPONSE:0:200}..."
    else
        print_error "Student search returned invalid JSON format"
        echo "Response: $SEARCH_RESPONSE"
    fi
else
    print_error "Student search API request failed"
fi

# Test 4: Payment Search Functionality
print_test "4. Testing payment search functionality..."
PAYMENT_SEARCH_RESPONSE=$(curl -s "$BASE_URL/api/payments?search=Test" 2>/dev/null)
PAYMENT_SEARCH_STATUS=$?

if [ $PAYMENT_SEARCH_STATUS -eq 0 ]; then
    if echo "$PAYMENT_SEARCH_RESPONSE" | grep -q '"payments"'; then
        print_success "Payment search API working"
        echo "Sample response: ${PAYMENT_SEARCH_RESPONSE:0:200}..."
    else
        print_error "Payment search returned invalid JSON format"
        echo "Response: $PAYMENT_SEARCH_RESPONSE"
    fi
else
    print_error "Payment search API request failed"
fi

# Test 5: Database Connectivity
print_test "5. Testing database connectivity..."
DB_TEST_RESPONSE=$(curl -s "$BASE_URL/api/dashboard/stats" 2>/dev/null)
DB_TEST_STATUS=$?

if [ $DB_TEST_STATUS -eq 0 ]; then
    if echo "$DB_TEST_RESPONSE" | grep -q '"totalStudents"'; then
        TOTAL_STUDENTS=$(echo "$DB_TEST_RESPONSE" | grep -o '"totalStudents":[0-9]*' | grep -o '[0-9]*')
        print_success "Database connectivity working - Total students: $TOTAL_STUDENTS"
    else
        print_error "Database query returned invalid format"
        echo "Response: $DB_TEST_RESPONSE"
    fi
else
    print_error "Database connectivity test failed"
fi

# Test 6: Frontend Assets
print_test "6. Testing frontend assets..."
FRONTEND_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/" 2>/dev/null || echo "000")
if [ "$FRONTEND_STATUS" = "200" ]; then
    print_success "Frontend assets loading (HTTP $FRONTEND_STATUS)"
else
    print_error "Frontend assets failed to load (HTTP $FRONTEND_STATUS)"
fi

# Test 7: External Access
print_test "7. Testing external access..."
EXTERNAL_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$EXTERNAL_URL/" 2>/dev/null || echo "000")
if [ "$EXTERNAL_STATUS" = "200" ]; then
    print_success "External access working (HTTP $EXTERNAL_STATUS)"
else
    print_warning "External access may have issues (HTTP $EXTERNAL_STATUS)"
    echo "This might be normal if testing from inside the server"
fi

# Test 8: Service Status
print_test "8. Testing service status..."
if systemctl is-active --quiet psa-nashik; then
    print_success "PSA service is running"
    
    # Get memory usage
    MEMORY_USAGE=$(systemctl show psa-nashik --property=MemoryCurrent --value 2>/dev/null)
    if [ -n "$MEMORY_USAGE" ] && [ "$MEMORY_USAGE" != "0" ]; then
        MEMORY_MB=$((MEMORY_USAGE / 1024 / 1024))
        echo "Memory usage: ${MEMORY_MB}MB"
    fi
else
    print_error "PSA service is not running"
    echo "Check with: systemctl status psa-nashik"
fi

# Summary
echo ""
echo "=============================================="
echo "🎯 SEARCH FUNCTIONALITY TEST SUMMARY"
echo "=============================================="

# Count passed tests
TOTAL_TESTS=8
PASSED_TESTS=0

# Re-run critical tests for summary
if [ "$HEALTH_STATUS" = "200" ]; then ((PASSED_TESTS++)); fi
if [ "$STUDENTS_STATUS" = "200" ]; then ((PASSED_TESTS++)); fi
if [ $SEARCH_STATUS -eq 0 ] && echo "$SEARCH_RESPONSE" | grep -q '"students"'; then ((PASSED_TESTS++)); fi
if [ $PAYMENT_SEARCH_STATUS -eq 0 ] && echo "$PAYMENT_SEARCH_RESPONSE" | grep -q '"payments"'; then ((PASSED_TESTS++)); fi
if [ $DB_TEST_STATUS -eq 0 ] && echo "$DB_TEST_RESPONSE" | grep -q '"totalStudents"'; then ((PASSED_TESTS++)); fi
if [ "$FRONTEND_STATUS" = "200" ]; then ((PASSED_TESTS++)); fi
if [ "$EXTERNAL_STATUS" = "200" ]; then ((PASSED_TESTS++)); fi
if systemctl is-active --quiet psa-nashik; then ((PASSED_TESTS++)); fi

echo "Tests passed: $PASSED_TESTS/$TOTAL_TESTS"

if [ $PASSED_TESTS -eq $TOTAL_TESTS ]; then
    print_success "🎉 All tests passed! Search functionality is working correctly."
elif [ $PASSED_TESTS -ge 6 ]; then
    print_warning "⚠️  Most tests passed. Minor issues detected."
else
    print_error "❌ Multiple test failures. Search functionality may not be working."
fi

echo ""
echo "🔍 MANUAL TESTING STEPS:"
echo "1. Visit: $EXTERNAL_URL/fees"
echo "2. Click 'Quick Record' tab"
echo "3. Type 'Test' in search box"
echo "4. Check for debug information and search results"
echo "5. Open browser console (F12) to see debug logs"
echo ""
echo "📊 LOGS TO CHECK:"
echo "- Service logs: journalctl -u psa-nashik -f"
echo "- Nginx logs: tail -f /var/log/nginx/error.log"
echo "- Application logs: tail -f /var/www/psa-nashik/logs/*.log"