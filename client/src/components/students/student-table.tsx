import { useState } from "react";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";
import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from "@/components/ui/alert-dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { DigitalCard } from "./digital-card";
import { StudentCard } from "./student-card";
import { useIsMobile } from "@/hooks/use-mobile";
import { useToast } from "@/hooks/use-toast";
import { Eye, CreditCard, MessageCircle, Edit, Trash2 } from "lucide-react";

interface Student {
  id: number;
  studentId: string;
  name: string;
  phone: string;
  email?: string;
  sportId: number;
  batchId: number;
  skillLevel: string;
  isActive: boolean;
  profileImageUrl?: string;
  joiningDate: string;
}

interface StudentTableProps {
  students: Student[];
  isLoading: boolean;
  sports: any[];
  batches: any[];
}

export function StudentTable({ students, isLoading, sports, batches }: StudentTableProps) {
  const [selectedStudent, setSelectedStudent] = useState<Student | null>(null);
  const [isCardDialogOpen, setIsCardDialogOpen] = useState(false);
  const [isViewDialogOpen, setIsViewDialogOpen] = useState(false);
  const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
  const [isCommentDialogOpen, setIsCommentDialogOpen] = useState(false);
  const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
  const [comment, setComment] = useState('');
  const [editForm, setEditForm] = useState<Partial<Student>>({});
  const isMobile = useIsMobile();
  const { toast } = useToast();
  const queryClient = useQueryClient();

  // Update student mutation
  const updateStudentMutation = useMutation({
    mutationFn: async ({ id, data }: { id: number; data: Partial<Student> }) => {
      const response = await fetch(`/api/students/${id}`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Failed to update student');
      }
      return response.json();
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['/api/students'] });
      toast({
        title: "Success",
        description: "Student updated successfully",
      });
      setIsEditDialogOpen(false);
    },
    onError: (error: Error) => {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive",
      });
    },
  });

  // Delete student mutation
  const deleteStudentMutation = useMutation({
    mutationFn: async (id: number) => {
      const response = await fetch(`/api/students/${id}`, {
        method: 'DELETE',
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Failed to delete student');
      }
      return response.json();
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['/api/students'] });
      toast({
        title: "Success",
        description: "Student deleted successfully",
      });
      setIsDeleteDialogOpen(false);
    },
    onError: (error: Error) => {
      toast({
        title: "Error",
        description: error.message,
        variant: "destructive",
      });
    },
  });

  const getSportName = (sportId: number) => {
    return sports.find(s => s.id === sportId)?.name || 'Unknown';
  };

  const getBatchName = (batchId: number) => {
    return batches.find(b => b.id === batchId)?.name || 'Unknown';
  };

  const getSkillLevelColor = (level: string) => {
    switch (level) {
      case 'beginner':
        return 'bg-green-100 text-green-800';
      case 'intermediate':
        return 'bg-yellow-100 text-yellow-800';
      case 'advanced':
        return 'bg-red-100 text-red-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  const handleViewCard = (student: Student) => {
    setSelectedStudent(student);
    setIsCardDialogOpen(true);
  };

  const handleEditStudent = (student: Student) => {
    setSelectedStudent(student);
    setEditForm({
      id: student.id,
      name: student.name,
      phone: student.phone,
      email: student.email,
      sportId: student.sportId,
      batchId: student.batchId,
      skillLevel: student.skillLevel,
      profileImageUrl: student.profileImageUrl
    });
    setIsEditDialogOpen(true);
  };

  const handleViewStudent = (student: Student) => {
    setSelectedStudent(student);
    setIsViewDialogOpen(true);
  };

  const handleCommentStudent = (student: Student) => {
    setSelectedStudent(student);
    setComment('');
    setIsCommentDialogOpen(true);
  };

  const handleDeleteStudent = (student: Student) => {
    setSelectedStudent(student);
    setIsDeleteDialogOpen(true);
  };

  const handleSaveEdit = () => {
    if (!selectedStudent) return;
    updateStudentMutation.mutate({ id: selectedStudent.id, data: editForm });
  };

  const handleProfileImageUpload = async (event: React.ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0];
    if (!file || !selectedStudent) return;

    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
      toast({
        title: "Error",
        description: "File size must be less than 5MB",
        variant: "destructive"
      });
      return;
    }

    // Validate file type
    if (!file.type.startsWith('image/')) {
      toast({
        title: "Error", 
        description: "Please select an image file",
        variant: "destructive"
      });
      return;
    }

    try {
      const formData = new FormData();
      formData.append('profileImage', file);

      const response = await fetch(`/api/upload/profile/${selectedStudent.id}`, {
        method: 'POST',
        body: formData,
      });

      if (!response.ok) {
        throw new Error('Upload failed');
      }

      const result = await response.json();
      
      // Update the edit form with the new profile image URL
      setEditForm(prev => ({
        ...prev,
        profileImageUrl: result.profileImageUrl
      }));

      toast({
        title: "Success",
        description: "Profile image uploaded successfully"
      });

      // Refresh the students data
      queryClient.invalidateQueries({ queryKey: ['/api/students'] });
    } catch (error) {
      console.error('Upload error:', error);
      toast({
        title: "Error",
        description: "Failed to upload profile image",
        variant: "destructive"
      });
    }
  };

  const handleSaveComment = async () => {
    if (!selectedStudent || !comment.trim()) return;
    
    try {
      // For now, just show a success message
      toast({
        title: "Success",
        description: `Comment added for ${selectedStudent.name}`,
      });
      setIsCommentDialogOpen(false);
      setComment('');
    } catch (error) {
      toast({
        title: "Error",
        description: "Failed to add comment",
        variant: "destructive",
      });
    }
  };

  const handleConfirmDelete = () => {
    if (!selectedStudent) return;
    deleteStudentMutation.mutate(selectedStudent.id);
  };

  const handleRecordPayment = (student: Student | null) => {
    if (!student) return;
    // Navigate to fees page with student pre-selected
    window.location.href = `/fees?studentId=${student.id}&tab=quick-record`;
  };

  const handleViewPaymentHistory = (student: Student | null) => {
    if (!student) return;
    // Navigate to fees page with student search
    window.location.href = `/fees?search=${student.name}&tab=overview`;
  };

  const handleSendFeeReminder = async (student: Student | null) => {
    if (!student) return;
    
    try {
      const response = await fetch('/api/notifications/fee-reminder', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        credentials: 'include',
        body: JSON.stringify({
          studentId: student.id,
          amount: 1000, // Default amount, can be customized
          dueDate: new Date().toISOString(),
          monthYear: new Date().toISOString().slice(0, 7)
        }),
      });

      if (response.ok) {
        toast({
          title: "Reminder Sent",
          description: `Fee reminder sent to ${student.name}`,
        });
      } else {
        throw new Error('Failed to send reminder');
      }
    } catch (error) {
      toast({
        title: "Error",
        description: "Failed to send fee reminder. Please check your notification settings.",
        variant: "destructive",
      });
    }
  };

  if (isLoading) {
    return (
      <div className="data-table">
        <div className="p-6">
          <div className="animate-pulse space-y-4">
            {[...Array(5)].map((_, i) => (
              <div key={i} className="h-16 bg-gray-200 rounded"></div>
            ))}
          </div>
        </div>
      </div>
    );
  }

  return (
    <>
      {isMobile ? (
        // Mobile card view
        <div className="grid grid-cols-1 gap-4">
          {students.map((student) => (
            <StudentCard
              key={student.id}
              student={student}
              onEdit={() => handleEditStudent(student)}
              onDelete={() => handleDeleteStudent(student)}
            />
          ))}
        </div>
      ) : (
        // Desktop table view
        <div className="data-table">
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Student
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Contact
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Sport & Batch
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Skill Level
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Status
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                {students.map((student) => (
                  <tr key={student.id} className="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="flex items-center">
                        <Avatar className="h-10 w-10">
                          <AvatarImage src={student.profileImageUrl} alt={student.name} />
                          <AvatarFallback>
                            {student.name.split(' ').map(n => n[0]).join('')}
                          </AvatarFallback>
                        </Avatar>
                        <div className="ml-4">
                          <div className="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {student.name}
                          </div>
                          <div className="text-sm text-gray-500 dark:text-gray-400">
                            ID: {student.studentId}
                          </div>
                        </div>
                      </div>
                    </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <div className="text-sm text-gray-900 dark:text-gray-100">{student.phone}</div>
                    {student.email && (
                      <div className="text-sm text-gray-500 dark:text-gray-400">{student.email}</div>
                    )}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <div className="text-sm text-gray-900 dark:text-gray-100">{getSportName(student.sportId)}</div>
                    <div className="text-sm text-gray-500 dark:text-gray-400">{getBatchName(student.batchId)}</div>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <Badge className={`status-badge ${getSkillLevelColor(student.skillLevel)}`}>
                      {student.skillLevel}
                    </Badge>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <Badge className={`status-badge ${student.isActive ? 'status-paid' : 'status-overdue'}`}>
                      {student.isActive ? 'Active' : 'Inactive'}
                    </Badge>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div className="flex items-center space-x-2">
                      <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => handleViewCard(student)}
                      >
                        <CreditCard className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="ghost" 
                        size="sm" 
                        onClick={() => handleViewStudent(student)}
                        title="View Student"
                      >
                        <Eye className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="ghost" 
                        size="sm" 
                        onClick={() => handleEditStudent(student)}
                        title="Edit Student"
                      >
                        <Edit className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="ghost" 
                        size="sm" 
                        onClick={() => handleCommentStudent(student)}
                        title="Add Comment"
                      >
                        <MessageCircle className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="ghost" 
                        size="sm" 
                        onClick={() => handleDeleteStudent(student)}
                        title="Delete Student"
                        className="hover:bg-red-100 hover:text-red-600"
                      >
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
      )}

      {/* Digital Card Dialog */}
      <Dialog open={isCardDialogOpen} onOpenChange={setIsCardDialogOpen}>
        <DialogContent className="max-w-md">
          <DialogHeader>
            <DialogTitle>Student Digital Card</DialogTitle>
          </DialogHeader>
          {selectedStudent && (
            <DigitalCard
              student={selectedStudent}
              sport={getSportName(selectedStudent.sportId)}
              batch={getBatchName(selectedStudent.batchId)}
            />
          )}
        </DialogContent>
      </Dialog>

      {/* View Student Dialog */}
      <Dialog open={isViewDialogOpen} onOpenChange={setIsViewDialogOpen}>
        <DialogContent className="max-w-md">
          <DialogHeader>
            <DialogTitle>Student Details</DialogTitle>
          </DialogHeader>
          {selectedStudent && (
            <div className="space-y-4">
              <div className="flex items-center space-x-4">
                <Avatar className="h-16 w-16">
                  <AvatarImage src={selectedStudent.profileImageUrl} alt={selectedStudent.name} />
                  <AvatarFallback>
                    {selectedStudent.name.split(' ').map(n => n[0]).join('')}
                  </AvatarFallback>
                </Avatar>
                <div>
                  <h3 className="text-lg font-semibold">{selectedStudent.name}</h3>
                  <p className="text-sm text-gray-500">ID: {selectedStudent.studentId}</p>
                </div>
              </div>
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <Label className="text-sm font-medium">Phone</Label>
                  <p className="text-sm">{selectedStudent.phone}</p>
                </div>
                <div>
                  <Label className="text-sm font-medium">Email</Label>
                  <p className="text-sm">{selectedStudent.email || 'Not provided'}</p>
                </div>
                <div>
                  <Label className="text-sm font-medium">Sport</Label>
                  <p className="text-sm">{getSportName(selectedStudent.sportId)}</p>
                </div>
                <div>
                  <Label className="text-sm font-medium">Batch</Label>
                  <p className="text-sm">{getBatchName(selectedStudent.batchId)}</p>
                </div>
                <div>
                  <Label className="text-sm font-medium">Skill Level</Label>
                  <Badge className={`status-badge ${getSkillLevelColor(selectedStudent.skillLevel)}`}>
                    {selectedStudent.skillLevel}
                  </Badge>
                </div>
                <div>
                  <Label className="text-sm font-medium">Status</Label>
                  <Badge className={`status-badge ${selectedStudent.isActive ? 'status-paid' : 'status-overdue'}`}>
                    {selectedStudent.isActive ? 'Active' : 'Inactive'}
                  </Badge>
                </div>
              </div>
            </div>
          )}
        </DialogContent>
      </Dialog>

      {/* Edit Student Dialog */}
      <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
        <DialogContent className="max-w-lg">
          <DialogHeader>
            <DialogTitle>Edit Student</DialogTitle>
          </DialogHeader>
          <div className="space-y-4">
            <div>
              <Label htmlFor="name">Name</Label>
              <Input
                id="name"
                value={editForm.name || ''}
                onChange={(e) => setEditForm({ ...editForm, name: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="phone">Phone</Label>
              <Input
                id="phone"
                value={editForm.phone || ''}
                onChange={(e) => setEditForm({ ...editForm, phone: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="email">Email</Label>
              <Input
                id="email"
                type="email"
                value={editForm.email || ''}
                onChange={(e) => setEditForm({ ...editForm, email: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="profileImage">Profile Image</Label>
              <div className="flex items-center space-x-4">
                <Avatar className="h-16 w-16">
                  <AvatarImage src={editForm.profileImageUrl} alt={editForm.name} />
                  <AvatarFallback>
                    {editForm.name?.split(' ').map(n => n[0]).join('') || 'ST'}
                  </AvatarFallback>
                </Avatar>
                <div>
                  <Button
                    type="button"
                    variant="outline"
                    size="sm"
                    onClick={() => document.getElementById('profile-image-upload')?.click()}
                  >
                    Upload New Image
                  </Button>
                  <input
                    id="profile-image-upload"
                    type="file"
                    accept="image/*"
                    className="hidden"
                    onChange={handleProfileImageUpload}
                  />
                  <p className="text-xs text-gray-500 mt-1">Max 5MB, JPG/PNG only</p>
                </div>
              </div>
            </div>
            <div>
              <Label htmlFor="sport">Sport</Label>
              <select
                id="sport"
                value={editForm.sportId || ''}
                onChange={(e) => {
                  const sportId = parseInt(e.target.value);
                  setEditForm({ ...editForm, sportId, batchId: undefined });
                }}
                className="w-full p-2 border rounded"
              >
                <option value="">Select a sport</option>
                {sports.map((sport) => (
                  <option key={sport.id} value={sport.id}>
                    {sport.name}
                  </option>
                ))}
              </select>
            </div>
            <div>
              <Label htmlFor="batch">Batch</Label>
              <select
                id="batch"
                value={editForm.batchId || ''}
                onChange={(e) => setEditForm({ ...editForm, batchId: parseInt(e.target.value) })}
                className="w-full p-2 border rounded"
                disabled={!editForm.sportId}
              >
                <option value="">Select a batch</option>
                {batches
                  .filter(batch => batch.sportId === editForm.sportId)
                  .map((batch) => (
                    <option key={batch.id} value={batch.id}>
                      {batch.schedule.time} - {batch.name}
                    </option>
                  ))}
              </select>
            </div>
            <div>
              <Label htmlFor="skillLevel">Skill Level</Label>
              <select
                id="skillLevel"
                value={editForm.skillLevel || ''}
                onChange={(e) => setEditForm({ ...editForm, skillLevel: e.target.value })}
                className="w-full p-2 border rounded"
              >
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
              </select>
            </div>
            
            {/* Fee Management Section */}
            <div className="border-t pt-4">
              <h3 className="text-lg font-semibold mb-3 flex items-center">
                <CreditCard className="h-5 w-5 mr-2" />
                Fee Management
              </h3>
              <div className="space-y-3">
                <Button
                  type="button"
                  variant="outline"
                  size="sm"
                  onClick={() => handleRecordPayment(selectedStudent)}
                  className="w-full"
                >
                  Record Payment
                </Button>
                <Button
                  type="button"
                  variant="outline"
                  size="sm"
                  onClick={() => handleViewPaymentHistory(selectedStudent)}
                  className="w-full"
                >
                  View Payment History
                </Button>
                <Button
                  type="button"
                  variant="outline"
                  size="sm"
                  onClick={() => handleSendFeeReminder(selectedStudent)}
                  className="w-full"
                >
                  Send Fee Reminder
                </Button>
              </div>
            </div>
            
            <div className="flex justify-end space-x-2">
              <Button variant="outline" onClick={() => setIsEditDialogOpen(false)}>
                Cancel
              </Button>
              <Button onClick={handleSaveEdit}>
                Save Changes
              </Button>
            </div>
          </div>
        </DialogContent>
      </Dialog>

      {/* Comment Dialog */}
      <Dialog open={isCommentDialogOpen} onOpenChange={setIsCommentDialogOpen}>
        <DialogContent className="max-w-md">
          <DialogHeader>
            <DialogTitle>Add Comment</DialogTitle>
          </DialogHeader>
          <div className="space-y-4">
            <div>
              <Label htmlFor="comment">Comment for {selectedStudent?.name}</Label>
              <Textarea
                id="comment"
                value={comment}
                onChange={(e) => setComment(e.target.value)}
                placeholder="Enter your comment..."
                rows={4}
              />
            </div>
            <div className="flex justify-end space-x-2">
              <Button variant="outline" onClick={() => setIsCommentDialogOpen(false)}>
                Cancel
              </Button>
              <Button onClick={handleSaveComment}>
                Save Comment
              </Button>
            </div>
          </div>
        </DialogContent>
      </Dialog>

      {/* Delete Confirmation Dialog */}
      <AlertDialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Are you sure?</AlertDialogTitle>
            <AlertDialogDescription>
              This action cannot be undone. This will permanently delete the student record for {selectedStudent?.name}.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Cancel</AlertDialogCancel>
            <AlertDialogAction onClick={handleConfirmDelete} className="bg-red-600 hover:bg-red-700">
              Delete
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </>
  );
}
