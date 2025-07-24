import { useState, useEffect } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { useQuery, useMutation } from "@tanstack/react-query";
import { apiRequest } from "@/lib/queryClient";
import { useToast } from "@/hooks/use-toast";
import { Search, CreditCard, Banknote, Smartphone, Globe, CheckCircle } from "lucide-react";
import { queryClient } from "@/lib/queryClient";

interface Student {
  id: number;
  studentId: string;
  name: string;
  phone: string;
  email?: string;
  sportId: number;
  batchId: number;
  isActive: boolean;
  joiningDate: string;
}

interface Sport {
  id: number;
  name: string;
  monthlyFee: number;
}

interface Batch {
  id: number;
  name: string;
  timings: string;
}

export function PaymentRecorder() {
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedStudent, setSelectedStudent] = useState<Student | null>(null);
  const [paymentMethod, setPaymentMethod] = useState("");
  const [amount, setAmount] = useState("");
  const [isProcessing, setIsProcessing] = useState(false);
  const { toast } = useToast();

  // Debug: Test if JavaScript is working
  console.log("🚀 PaymentRecorder component loaded, searchTerm:", searchTerm);

  // Simple state-based search instead of React Query
  const [searchResults, setSearchResults] = useState<{ students: Student[]; total: number } | null>(null);
  const [isSearching, setIsSearching] = useState(false);
  const [searchError, setSearchError] = useState<Error | null>(null);

  // Monitor searchResults state changes
  useEffect(() => {
    console.log("🔍 STATE MONITOR: searchResults changed:", searchResults);
    console.log("🔍 STATE MONITOR: searchResults type:", typeof searchResults);
    if (searchResults) {
      console.log("🔍 STATE MONITOR: searchResults.students:", searchResults.students);
      console.log("🔍 STATE MONITOR: searchResults.students type:", typeof searchResults.students);
      console.log("🔍 STATE MONITOR: searchResults.students length:", searchResults.students?.length);
      console.log("🔍 STATE MONITOR: searchResults.total:", searchResults.total);
    }
  }, [searchResults]);

  // Effect to handle search
  useEffect(() => {
    if (searchTerm.length <= 2) {
      setSearchResults(null);
      setSearchError(null);
      return;
    }

    const searchStudents = async () => {
      console.log("🔍 SIMPLE SEARCH: Starting search for:", searchTerm);
      setIsSearching(true);
      setSearchError(null);

      try {
        const url = `/api/students/search?query=${encodeURIComponent(searchTerm)}`;
        console.log("🔍 SIMPLE SEARCH: URL:", url);
        
        const response = await fetch(url, {
          method: "GET",
          credentials: "include",
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
          }
        });

        console.log("🔍 SIMPLE SEARCH: Response:", response);
        console.log("🔍 SIMPLE SEARCH: Status:", response.status);
        console.log("🔍 SIMPLE SEARCH: OK:", response.ok);

        if (!response.ok) {
          throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const data = await response.json();
        console.log("🔍 SIMPLE SEARCH: Data received:", data);
        console.log("🔍 SIMPLE SEARCH: Data type:", typeof data);
        console.log("🔍 SIMPLE SEARCH: Data keys:", Object.keys(data));
        console.log("🔍 SIMPLE SEARCH: Students:", data.students);
        console.log("🔍 SIMPLE SEARCH: Students type:", typeof data.students);
        console.log("🔍 SIMPLE SEARCH: Students length:", data.students?.length);
        console.log("🔍 SIMPLE SEARCH: Total:", data.total);
        console.log("🔍 SIMPLE SEARCH: Total type:", typeof data.total);

        console.log("🔍 SIMPLE SEARCH: About to set search results...");
        setSearchResults(data);
        console.log("🔍 SIMPLE SEARCH: Search results set successfully");
      } catch (error) {
        console.error("🔍 SIMPLE SEARCH: Error:", error);
        setSearchError(error as Error);
      } finally {
        setIsSearching(false);
      }
    };

    const timeoutId = setTimeout(searchStudents, 300); // Debounce
    return () => clearTimeout(timeoutId);
  }, [searchTerm]);

  // Old React Query code (commented out for debugging)
  /*
  const { data: searchResults, isLoading: isSearching, error: searchError } = useQuery({
    queryKey: ["/api/students/search", searchTerm],
    enabled: searchTerm.length > 2,
    queryFn: async () => {
      console.log("🔍 REACT QUERY: Starting search for term:", searchTerm);
      console.log("🔍 REACT QUERY: URL:", `/api/students/search?query=${encodeURIComponent(searchTerm)}`);
      
      try {
        console.log("🔍 REACT QUERY: About to make fetch request...");
        
        // Use direct fetch instead of apiRequest to avoid authentication issues
        const response = await fetch(`/api/students/search?query=${encodeURIComponent(searchTerm)}`, {
          method: "GET",
          credentials: "include",
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
          }
        });
        
        console.log("🔍 REACT QUERY: Fetch completed");
        console.log("🔍 REACT QUERY: Response object:", response);
        console.log("🔍 REACT QUERY: Response status:", response.status);
        console.log("🔍 REACT QUERY: Response ok:", response.ok);
        console.log("🔍 REACT QUERY: Response headers:", [...response.headers.entries()]);
        
        if (!response.ok) {
          const errorText = await response.text();
          console.error("🔍 REACT QUERY: Error response text:", errorText);
          throw new Error(`HTTP ${response.status}: ${response.statusText} - ${errorText}`);
        }
        
        console.log("🔍 REACT QUERY: About to parse JSON...");
        const result = await response.json();
        console.log("🔍 REACT QUERY: JSON parsed successfully");
        console.log("✅ REACT QUERY: Search results received:", result);
        console.log("📊 REACT QUERY: Students array:", result?.students);
        console.log("📊 REACT QUERY: Students length:", result?.students?.length);
        console.log("🔢 REACT QUERY: Total count:", result?.total);
        console.log("🔍 REACT QUERY: Result type:", typeof result);
        console.log("🔍 REACT QUERY: Result keys:", Object.keys(result || {}));
        
        // Validate the response structure
        if (!result || typeof result !== 'object') {
          throw new Error(`Invalid response format: expected object, got ${typeof result}`);
        }
        
        if (!Array.isArray(result.students)) {
          console.warn("🔍 REACT QUERY: Students is not an array:", result.students);
          result.students = [];
        }
        
        if (typeof result.total !== 'number') {
          console.warn("🔍 REACT QUERY: Total is not a number:", result.total);
          result.total = result.students?.length || 0;
        }
        
        console.log("🔍 REACT QUERY: Returning validated result:", result);
        return result;
        
      } catch (error) {
        console.error("❌ REACT QUERY: Caught error:", error);
        console.error("❌ REACT QUERY: Error type:", typeof error);
        console.error("❌ REACT QUERY: Error message:", error?.message);
        console.error("❌ REACT QUERY: Error stack:", error?.stack);
        throw error;
      }
    },
  });
  */

  // Get sports data
  const { data: sports = [], error: sportsError, isLoading: sportsLoading } = useQuery({
    queryKey: ["/api/sports"],
    queryFn: async () => {
      try {
        const response = await apiRequest("GET", "/api/sports");
        const result = await response.json();
        console.log("🏃 Sports data loaded:", result);
        return result;
      } catch (error) {
        console.error("❌ Sports API error:", error);
        throw error;
      }
    },
  });

  // Get batches data
  const { data: batches = [], error: batchesError, isLoading: batchesLoading } = useQuery({
    queryKey: ["/api/batches"],
    queryFn: async () => {
      try {
        const response = await apiRequest("GET", "/api/batches");
        const result = await response.json();
        console.log("📚 Batches data loaded:", result);
        return result;
      } catch (error) {
        console.error("❌ Batches API error:", error);
        throw error;
      }
    },
  });

  // Payment recording mutation
  const recordPaymentMutation = useMutation({
    mutationFn: async (paymentData: any) => {
      return apiRequest("POST", "/api/payments", paymentData);
    },
    onSuccess: () => {
      toast({
        title: "Payment Recorded Successfully",
        description: "The payment has been recorded in the system.",
      });
      // Reset form
      setSelectedStudent(null);
      setPaymentMethod("");
      setAmount("");
      setSearchTerm("");
      setIsProcessing(false);
      // Invalidate relevant queries
      queryClient.invalidateQueries({ queryKey: ["/api/payments"] });
      queryClient.invalidateQueries({ queryKey: ["/api/dashboard/stats"] });
    },
    onError: (error: any) => {
      toast({
        title: "Payment Recording Failed",
        description: error.message || "There was an error recording the payment.",
        variant: "destructive",
      });
      setIsProcessing(false);
    },
  });

  const handleStudentSelect = (student: Student) => {
    console.log("👤 Student selected:", student);
    console.log("🏃 Available sports:", sports);
    console.log("📚 Available batches:", batches);
    
    try {
      setSelectedStudent(student);
      setSearchTerm(student.name);
      
      const sport = getStudentSport(student.sportId);
      console.log("🏃 Found sport for student:", sport);
      
      if (sport && sport.monthlyFee) {
        setAmount(sport.monthlyFee.toString());
        console.log("💰 Set amount to:", sport.monthlyFee);
      } else {
        console.warn("⚠️ No sport found or no monthly fee for sportId:", student.sportId);
        setAmount("0");
      }
    } catch (error) {
      console.error("❌ Error in handleStudentSelect:", error);
      toast({
        title: "Error",
        description: "Failed to select student. Please try again.",
        variant: "destructive",
      });
    }
  };

  const handlePaymentSubmit = async () => {
    if (!selectedStudent || !paymentMethod || !amount) {
      toast({
        title: "Missing Information",
        description: "Please complete all fields before recording payment.",
        variant: "destructive",
      });
      return;
    }

    setIsProcessing(true);
    
    const paymentData = {
      studentId: selectedStudent.id,
      amount: parseFloat(amount),
      paymentMethod,
      status: "paid",
      monthYear: new Date().toISOString().slice(0, 7), // YYYY-MM format
      paidAt: new Date().toISOString(),
    };

    recordPaymentMutation.mutate(paymentData);
  };

  const getStudentSport = (sportId: number) => {
    if (!sports || !Array.isArray(sports)) {
      console.warn("⚠️ Sports data not available:", sports);
      return null;
    }
    return sports.find((s: Sport) => s.id === sportId) || null;
  };

  const getStudentBatch = (batchId: number) => {
    if (!batches || !Array.isArray(batches)) {
      console.warn("⚠️ Batches data not available:", batches);
      return null;
    }
    return batches.find((b: Batch) => b.id === batchId) || null;
  };

  const paymentMethods = [
    { value: "cash", label: "Cash", icon: Banknote },
    { value: "upi", label: "UPI", icon: Smartphone },
    { value: "card", label: "Card", icon: CreditCard },
    { value: "online", label: "Online", icon: Globe },
  ];

  return (
    <div className="max-w-4xl mx-auto p-4 space-y-6">
      <div className="text-center mb-6">
        <h1 className="text-2xl font-bold text-gray-900 dark:text-gray-100">Record Payment</h1>
        <p className="text-gray-600 dark:text-gray-400">Quick and easy payment recording</p>
      </div>

      {/* System Status Debug */}
      {(sportsError || batchesError || sportsLoading || batchesLoading) && (
        <Card className="border-orange-200 bg-orange-50 dark:bg-orange-900/20">
          <CardContent className="pt-4">
            <div className="text-sm space-y-2">
              <div className="font-medium text-orange-800 dark:text-orange-200">🔧 System Status:</div>
              <div className="space-y-1 text-orange-700 dark:text-orange-300">
                <p>Sports Loading: {sportsLoading ? "🔄 Loading..." : "✅ Complete"}</p>
                <p>Batches Loading: {batchesLoading ? "🔄 Loading..." : "✅ Complete"}</p>
                <p>Sports Data: {sports?.length || 0} items loaded</p>
                <p>Batches Data: {batches?.length || 0} items loaded</p>
                {sportsError && <p className="text-red-600">❌ Sports Error: {sportsError.message}</p>}
                {batchesError && <p className="text-red-600">❌ Batches Error: {batchesError.message}</p>}
              </div>
            </div>
          </CardContent>
        </Card>
      )}

      {/* Step 1: Search Student */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Search className="h-5 w-5" />
            Search Student
          </CardTitle>
        </CardHeader>
        <CardContent>
          <div className="relative">
            <Input
              placeholder="Type student name to search..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="pr-10"
            />
            {isSearching && (
              <div className="absolute right-3 top-1/2 transform -translate-y-1/2">
                <div className="animate-spin w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full"></div>
              </div>
            )}
          </div>

          {/* Debug Information */}
          {searchTerm.length > 2 && (
            <div className="mt-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg text-sm">
              <div className="font-medium text-gray-700 dark:text-gray-300 mb-2">🔍 Search Debug Info:</div>
              <div className="space-y-1 text-gray-600 dark:text-gray-400">
                <p>Search term: "{searchTerm}" (length: {searchTerm.length})</p>
                <p>Query enabled: {searchTerm.length > 2 ? "✅ Yes" : "❌ No"}</p>
                <div className="mt-2">
                  <button
                    onClick={() => {
                      // Simplest possible test
                      window.alert("✅ JavaScript is working!");
                    }}
                    className="px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600 mr-2"
                  >
                    ✅ JS Test
                  </button>
                  <button
                    onClick={() => {
                      // Test fetch without async/await
                      fetch("/api/students/search?query=Priya")
                        .then(response => response.text())
                        .then(text => {
                          window.alert(`Raw response: ${text.substring(0, 100)}...`);
                        })
                        .catch(error => {
                          window.alert(`Error: ${error.message}`);
                        });
                    }}
                    className="px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600 mr-2"
                  >
                    🔍 Fetch Test
                  </button>
                  <button
                    onClick={async () => {
                      console.log("🧪 DIRECT TEST: Starting direct fetch call");
                      console.log("🧪 DIRECT TEST: Search term:", searchTerm);
                      console.log("🧪 DIRECT TEST: URL:", `/api/students/search?query=${encodeURIComponent(searchTerm)}`);
                      
                      try {
                        console.log("🧪 DIRECT TEST: About to make fetch request...");
                        const response = await fetch(`/api/students/search?query=${encodeURIComponent(searchTerm)}`, {
                          method: "GET",
                          credentials: "include",
                          headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                          }
                        });
                        
                        console.log("🧪 DIRECT TEST: Fetch completed");
                        console.log("🧪 DIRECT TEST: Response object:", response);
                        console.log("🧪 DIRECT TEST: Response status:", response.status);
                        console.log("🧪 DIRECT TEST: Response ok:", response.ok);
                        console.log("🧪 DIRECT TEST: Response headers:", [...response.headers.entries()]);
                        
                        if (!response.ok) {
                          throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        
                        console.log("🧪 DIRECT TEST: About to read response text...");
                        const text = await response.text();
                        console.log("🧪 DIRECT TEST: Raw text length:", text.length);
                        console.log("🧪 DIRECT TEST: Raw text:", text);
                        
                        console.log("🧪 DIRECT TEST: About to parse JSON...");
                        const json = JSON.parse(text);
                        console.log("🧪 DIRECT TEST: JSON parsed successfully");
                        console.log("🧪 DIRECT TEST: Parsed JSON:", json);
                        console.log("🧪 DIRECT TEST: Students array:", json.students);
                        console.log("🧪 DIRECT TEST: Students length:", json.students?.length);
                        console.log("🧪 DIRECT TEST: Total:", json.total);
                        
                        const message = `✅ SUCCESS!\nStudents found: ${json.students?.length || 0}\nTotal: ${json.total || 0}\nFirst student: ${json.students?.[0]?.name || 'None'}`;
                        console.log("🧪 DIRECT TEST: About to show alert:", message);
                        alert(message);
                        console.log("🧪 DIRECT TEST: Alert shown successfully");
                        
                      } catch (error) {
                        console.error("🧪 DIRECT TEST: Caught error:", error);
                        console.error("🧪 DIRECT TEST: Error type:", typeof error);
                        console.error("🧪 DIRECT TEST: Error message:", error?.message);
                        console.error("🧪 DIRECT TEST: Error stack:", error?.stack);
                        
                        const errorMessage = `❌ ERROR!\nType: ${typeof error}\nMessage: ${error?.message || 'Unknown error'}\nDetails: ${JSON.stringify(error, null, 2)}`;
                        console.log("🧪 DIRECT TEST: About to show error alert:", errorMessage);
                        alert(errorMessage);
                        console.log("🧪 DIRECT TEST: Error alert shown");
                      }
                    }}
                    className="px-3 py-1 bg-purple-500 text-white rounded text-xs hover:bg-purple-600"
                  >
                    🧪 Direct API Test
                  </button>
                </div>
                {isSearching && <p className="text-blue-600">🔄 Searching...</p>}
                {searchError && (
                  <div className="text-red-500">
                    <p>❌ Error: {searchError.message}</p>
                    <p>Details: {JSON.stringify(searchError, null, 2)}</p>
                  </div>
                )}
                {searchResults && (
                  <div className="text-green-600">
                    <p>✅ API Response received</p>
                    <p>Raw searchResults: {JSON.stringify(searchResults)}</p>
                    <p>searchResults type: {typeof searchResults}</p>
                    <p>searchResults.students: {JSON.stringify(searchResults.students)}</p>
                    <p>Students found: {searchResults.students?.length || 0}</p>
                    <p>Total in DB: {searchResults.total || 0}</p>
                    {searchResults.students?.length === 0 && (
                      <p className="text-orange-500">⚠️ No students match your search</p>
                    )}
                  </div>
                )}
                {!isSearching && !searchError && !searchResults && (
                  <p className="text-gray-500">⏳ Waiting for search...</p>
                )}
              </div>
            </div>
          )}

          {/* Search Results */}
          {searchResults && searchResults.students && searchResults.students.length > 0 && (
            <div className="mt-4 space-y-2 max-h-60 overflow-y-auto">
              {searchResults.students.map((student: Student) => (
                <div
                  key={student.id}
                  onClick={() => handleStudentSelect(student)}
                  className="p-3 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                >
                  <div className="flex items-center justify-between">
                    <div>
                      <h4 className="font-medium text-gray-900 dark:text-gray-100">{student.name}</h4>
                      <p className="text-sm text-gray-500 dark:text-gray-400">ID: {student.studentId}</p>
                      <p className="text-sm text-gray-500 dark:text-gray-400">{student.phone}</p>
                    </div>
                    <Badge variant={student.isActive ? "default" : "secondary"}>
                      {student.isActive ? "Active" : "Inactive"}
                    </Badge>
                  </div>
                </div>
              ))}
            </div>
          )}
        </CardContent>
      </Card>

      {/* Step 2: Student Details & Fee */}
      {selectedStudent && (
        <Card>
          <CardHeader>
            <CardTitle>Student Details & Fee</CardTitle>
          </CardHeader>
          <CardContent className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <Label className="text-sm font-medium text-gray-700 dark:text-gray-300">Student Name</Label>
                <p className="text-lg font-semibold text-gray-900 dark:text-gray-100">{selectedStudent.name}</p>
              </div>
              <div>
                <Label className="text-sm font-medium text-gray-700 dark:text-gray-300">Student ID</Label>
                <p className="text-lg font-semibold text-gray-900 dark:text-gray-100">{selectedStudent.studentId}</p>
              </div>
              <div>
                <Label className="text-sm font-medium text-gray-700 dark:text-gray-300">Sport</Label>
                <p className="text-lg font-semibold text-gray-900 dark:text-gray-100">
                  {getStudentSport(selectedStudent.sportId)?.name || "Unknown"}
                </p>
              </div>
              <div>
                <Label className="text-sm font-medium text-gray-700 dark:text-gray-300">Batch</Label>
                <p className="text-lg font-semibold text-gray-900 dark:text-gray-100">
                  {getStudentBatch(selectedStudent.batchId)?.name || "Unknown"}
                </p>
              </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <Label htmlFor="amount">Monthly Fee Amount</Label>
                <Input
                  id="amount"
                  type="number"
                  value={amount}
                  onChange={(e) => setAmount(e.target.value)}
                  className="text-lg font-semibold"
                  placeholder="0.00"
                />
              </div>
              <div>
                <Label htmlFor="month">Payment Month</Label>
                <Input
                  id="month"
                  type="month"
                  defaultValue={new Date().toISOString().slice(0, 7)}
                  className="text-lg"
                />
              </div>
            </div>
          </CardContent>
        </Card>
      )}

      {/* Step 3: Payment Method Selection */}
      {selectedStudent && (
        <Card>
          <CardHeader>
            <CardTitle>Payment Method</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {paymentMethods.map((method) => (
                <Button
                  key={method.value}
                  variant={paymentMethod === method.value ? "default" : "outline"}
                  onClick={() => setPaymentMethod(method.value)}
                  className="h-16 flex flex-col items-center justify-center gap-2"
                >
                  <method.icon className="h-6 w-6" />
                  <span className="text-sm">{method.label}</span>
                </Button>
              ))}
            </div>
          </CardContent>
        </Card>
      )}

      {/* Step 4: Submit Payment */}
      {selectedStudent && paymentMethod && amount && (
        <Card>
          <CardContent className="pt-6">
            <div className="text-center space-y-4">
              <div className="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <h3 className="text-lg font-semibold text-gray-900 dark:text-gray-100">Payment Summary</h3>
                <p className="text-gray-600 dark:text-gray-400">
                  Student: <span className="font-medium text-gray-900 dark:text-gray-100">{selectedStudent.name}</span>
                </p>
                <p className="text-gray-600 dark:text-gray-400">
                  Amount: <span className="font-medium text-gray-900 dark:text-gray-100">₹{amount}</span>
                </p>
                <p className="text-gray-600 dark:text-gray-400">
                  Method: <span className="font-medium text-gray-900 dark:text-gray-100">
                    {paymentMethods.find(m => m.value === paymentMethod)?.label}
                  </span>
                </p>
              </div>
              
              <Button
                onClick={handlePaymentSubmit}
                disabled={isProcessing}
                className="w-full md:w-auto px-8 py-3 text-lg"
              >
                {isProcessing ? (
                  <div className="flex items-center gap-2">
                    <div className="animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"></div>
                    Processing...
                  </div>
                ) : (
                  <div className="flex items-center gap-2">
                    <CheckCircle className="h-5 w-5" />
                    Record Payment
                  </div>
                )}
              </Button>
            </div>
          </CardContent>
        </Card>
      )}
    </div>
  );
}